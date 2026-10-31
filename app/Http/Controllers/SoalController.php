<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Soal;
use App\Models\Ujian;

class SoalController extends Controller {
    public function create($ujian_id) {
        return view('guru.soal.create', compact('ujian_id'));
    }

    /**
     * Simpan banyak soal sekaligus (konsep Google Forms).
     * Input: soal[<key>][pertanyaan|opsi_a..opsi_e|jawaban_benar|media_files[]]
     */
    public function store(Request $request, $ujian_id) {
        $request->validate([
            'soal' => 'required|array|min:1|max:100',
            'soal.*.pertanyaan' => 'required',
            'soal.*.media_files' => 'nullable|array|max:5',
            'soal.*.media_files.*' => 'file|mimes:jpg,jpeg,png,mp4,webm|max:20480', // max 20MB
            'soal.*.opsi_a' => 'required',
            'soal.*.opsi_b' => 'required',
            'soal.*.opsi_c' => 'required',
            'soal.*.opsi_d' => 'required',
            'soal.*.opsi_e' => 'nullable',
            'soal.*.jawaban_benar' => 'required|in:A,B,C,D,E',
        ], [], $this->attributeNames($request->input('soal', [])));

        $items = $request->input('soal');

        // Kunci jawaban E hanya valid bila opsi E diisi
        foreach (array_keys($items) as $pos => $key) {
            if (($items[$key]['jawaban_benar'] ?? null) === 'E' && trim($items[$key]['opsi_e'] ?? '') === '') {
                return back()->withInput()->withErrors(['soal' => 'Soal ke-' . ($pos + 1) . ': kunci jawaban E dipilih tetapi opsi E kosong.']);
            }
        }

        DB::transaction(function () use ($request, $items, $ujian_id) {
            foreach (array_keys($items) as $key) {
                $item = $items[$key];
                $mediaPaths = [];
                foreach ($request->file("soal.$key.media_files", []) as $file) {
                    $mediaPaths[] = $file->store('soal_media', 'public');
                }

                Soal::create([
                    'ujian_id' => $ujian_id,
                    'pertanyaan' => $item['pertanyaan'],
                    'opsi_a' => $item['opsi_a'],
                    'opsi_b' => $item['opsi_b'],
                    'opsi_c' => $item['opsi_c'],
                    'opsi_d' => $item['opsi_d'],
                    'opsi_e' => $item['opsi_e'] ?? null,
                    'jawaban_benar' => $item['jawaban_benar'],
                    'media_files' => count($mediaPaths) > 0 ? $mediaPaths : null,
                ]);
            }
        });

        return redirect()->route(auth()->user()->role . '.ujian.show', $ujian_id)->with('success', count($items) . ' soal berhasil ditambahkan');
    }

    private function attributeNames(array $items): array {
        $names = [];
        $fields = [
            'pertanyaan' => 'pertanyaan',
            'opsi_a' => 'opsi A', 'opsi_b' => 'opsi B', 'opsi_c' => 'opsi C',
            'opsi_d' => 'opsi D', 'opsi_e' => 'opsi E',
            'jawaban_benar' => 'kunci jawaban',
            'media_files' => 'media', 'media_files.*' => 'media',
        ];
        foreach (array_keys($items) as $pos => $key) {
            foreach ($fields as $field => $label) {
                $names["soal.$key.$field"] = $label . ' soal ke-' . ($pos + 1);
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
        $data = $request->validate([
            'pertanyaan' => 'required',
            'media_files' => 'nullable|array|max:5',
            'media_files.*' => 'file|mimes:jpg,jpeg,png,mp4,webm|max:20480',
            'delete_media' => 'nullable|array',
            'delete_media.*' => 'string',
            'opsi_a' => 'required',
            'opsi_b' => 'required',
            'opsi_c' => 'required',
            'opsi_d' => 'required',
            'opsi_e' => 'nullable',
            'jawaban_benar' => 'required|in:A,B,C,D,E'
        ]);

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
        
        $data['media_files'] = count($existingMedia) > 0 ? $existingMedia : null;
        unset($data['delete_media']);

        $soal->update($data);
        return redirect()->route(auth()->user()->role . '.ujian.show', $ujian_id)->with('success', 'Soal berhasil diperbarui');
    }
    public function destroy($ujian_id, $id) {
        Soal::destroy($id);
        return redirect()->route(auth()->user()->role . '.ujian.show', $ujian_id);
    }
}
