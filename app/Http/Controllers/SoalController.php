<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Soal;
use App\Models\Ujian;

class SoalController extends Controller {
    public function create($ujian_id) {
        $jumlahSoal = Soal::where('ujian_id', $ujian_id)->count();
        return view('guru.soal.create', compact('ujian_id', 'jumlahSoal'));
    }

    /**
     * Simpan banyak soal sekaligus (konsep Google Forms).
     * Input: soal[<key>][tipe|pertanyaan|bobot|opsi_a..opsi_e|jawaban_benar|pedoman|media_files[]]
     */
    public function store(Request $request, $ujian_id) {
        $items = $request->input('soal');
        if (is_array($items)) {
            foreach (array_keys($items) as $key) {
                if (!ctype_digit((string) $key)) {
                    abort(422, 'Format data soal tidak valid.');
                }
            }
        }

        $rules = ['soal' => 'required|array|min:1|max:100'];
        foreach ((array) $items as $key => $item) {
            $rules += $this->rulesFor("soal.$key", is_array($item) ? ($item['tipe'] ?? null) : null);
        }
        $offset = Soal::where('ujian_id', $ujian_id)->count();
        $request->validate($rules, [], $this->attributeNames((array) $items, $offset));

        // Kunci jawaban E hanya valid bila opsi E diisi
        foreach (array_keys($items) as $pos => $key) {
            $item = $items[$key];
            if ($item['tipe'] === Soal::TIPE_PG && ($item['jawaban_benar'] ?? null) === 'E' && trim($item['opsi_e'] ?? '') === '') {
                return back()->withInput()->withErrors(['soal' => 'Soal ke-' . ($offset + $pos + 1) . ': kunci jawaban E dipilih tetapi opsi E kosong.']);
            }
        }

        DB::transaction(function () use ($request, $items, $ujian_id) {
            foreach (array_keys($items) as $key) {
                $item = $items[$key];
                $mediaPaths = [];
                foreach ($request->file("soal.$key.media_files", []) as $file) {
                    $mediaPaths[] = $file->store('soal_media', 'public');
                }

                Soal::create(array_merge([
                    'ujian_id' => $ujian_id,
                    'tipe' => $item['tipe'],
                    'pertanyaan' => $item['pertanyaan'],
                    'bobot' => $item['bobot'] ?? 1,
                    'media_files' => count($mediaPaths) > 0 ? $mediaPaths : null,
                ], $this->isiPerTipe($item)));
            }
        });

        return redirect()->route(auth()->user()->role . '.ujian.show', $ujian_id)->with('success', count($items) . ' soal berhasil ditambahkan');
    }

    /** Aturan validasi satu soal sesuai jenisnya. */
    private function rulesFor(string $prefix, ?string $tipe): array {
        $rules = [
            "$prefix.tipe" => 'required|in:' . Soal::TIPE_PG . ',' . Soal::TIPE_ESAI,
            "$prefix.pertanyaan" => 'required',
            "$prefix.bobot" => 'nullable|integer|min:1|max:100',
            "$prefix.media_files" => 'nullable|array|max:5',
            "$prefix.media_files.*" => 'file|mimes:jpg,jpeg,png,mp4,webm|max:20480', // max 20MB
        ];

        if ($tipe === Soal::TIPE_ESAI) {
            $rules["$prefix.pedoman"] = 'nullable|string';
        } else {
            $rules["$prefix.opsi_a"] = 'required';
            $rules["$prefix.opsi_b"] = 'required';
            $rules["$prefix.opsi_c"] = 'required';
            $rules["$prefix.opsi_d"] = 'required';
            $rules["$prefix.opsi_e"] = 'nullable';
            $rules["$prefix.jawaban_benar"] = 'required|in:A,B,C,D,E';
        }
        return $rules;
    }

    /** Kolom khusus jenis soal: opsi+kunci (PG) atau pedoman (esai). */
    private function isiPerTipe(array $item): array {
        if ($item['tipe'] === Soal::TIPE_ESAI) {
            return [
                'opsi_a' => null, 'opsi_b' => null, 'opsi_c' => null, 'opsi_d' => null, 'opsi_e' => null,
                'jawaban_benar' => null,
                'pedoman' => $item['pedoman'] ?? null,
            ];
        }
        return [
            'opsi_a' => $item['opsi_a'],
            'opsi_b' => $item['opsi_b'],
            'opsi_c' => $item['opsi_c'],
            'opsi_d' => $item['opsi_d'],
            'opsi_e' => $item['opsi_e'] ?? null,
            'jawaban_benar' => $item['jawaban_benar'],
            'pedoman' => null,
        ];
    }

    private function attributeNames(array $items, int $offset = 0): array {
        $names = [];
        $fields = [
            'tipe' => 'jenis soal',
            'pertanyaan' => 'pertanyaan',
            'bobot' => 'poin',
            'pedoman' => 'pedoman jawaban',
            'opsi_a' => 'opsi A', 'opsi_b' => 'opsi B', 'opsi_c' => 'opsi C',
            'opsi_d' => 'opsi D', 'opsi_e' => 'opsi E',
            'jawaban_benar' => 'kunci jawaban',
            'media_files' => 'media', 'media_files.*' => 'media',
        ];
        foreach (array_keys($items) as $pos => $key) {
            foreach ($fields as $field => $label) {
                $names["soal.$key.$field"] = $label . ' soal ke-' . ($offset + $pos + 1);
            }
        }
        return $names;
    }

    public function edit($ujian_id, $id) {
        $data = Soal::findOrFail($id);
        return view('guru.soal.edit', compact('data', 'ujian_id'));
    }
    public function update(Request $request, $ujian_id, $id) {
        $soal = Soal::findOrFail($id);
        $tipe = $request->input('tipe');
        $rules = [
            'tipe' => 'required|in:' . Soal::TIPE_PG . ',' . Soal::TIPE_ESAI,
            'pertanyaan' => 'required',
            'bobot' => 'nullable|integer|min:1|max:100',
            'media_files' => 'nullable|array|max:5',
            'media_files.*' => 'file|mimes:jpg,jpeg,png,mp4,webm|max:20480',
            'delete_media' => 'nullable|array',
            'delete_media.*' => 'string',
        ];
        if ($tipe === Soal::TIPE_ESAI) {
            $rules['pedoman'] = 'nullable|string';
        } else {
            $rules += [
                'opsi_a' => 'required',
                'opsi_b' => 'required',
                'opsi_c' => 'required',
                'opsi_d' => 'required',
                'opsi_e' => 'nullable',
                'jawaban_benar' => 'required|in:A,B,C,D,E',
            ];
        }
        $input = $request->validate($rules);

        if ($tipe !== Soal::TIPE_ESAI && $input['jawaban_benar'] === 'E' && trim($input['opsi_e'] ?? '') === '') {
            return back()->withInput()->withErrors(['jawaban_benar' => 'Kunci jawaban E dipilih tetapi opsi E kosong.']);
        }

        $existingMedia = $soal->media_files ?? [];
        
        // Handle deletion of old media
        if ($request->has('delete_media')) {
            foreach ($request->delete_media as $toDelete) {
                if (($key = array_search($toDelete, $existingMedia)) !== false) {
                    unset($existingMedia[$key]);
                    @unlink(storage_path('app/public/' . $toDelete));
                }
            }
            $existingMedia = array_values($existingMedia); // reindex
        }

        // Add new media
        if ($request->hasFile('media_files')) {
            foreach ($request->file('media_files') as $file) {
                $existingMedia[] = $file->store('soal_media', 'public');
            }
        }

        $soal->update(array_merge([
            'tipe' => $input['tipe'],
            'pertanyaan' => $input['pertanyaan'],
            'bobot' => $input['bobot'] ?? 1,
            'media_files' => count($existingMedia) > 0 ? $existingMedia : null,
        ], $this->isiPerTipe($input)));

        return redirect()->route(auth()->user()->role . '.ujian.show', $ujian_id)->with('success', 'Soal berhasil diperbarui');
    }
    public function destroy($ujian_id, $id) {
        Soal::destroy($id);
        return redirect()->route(auth()->user()->role . '.ujian.show', $ujian_id);
    }
}
