<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Soal;
use App\Models\Ujian;

class SoalController extends Controller {
    public function create($ujian_id) {
        return view('guru.soal.create', compact('ujian_id'));
    }
    public function store(Request $request, $ujian_id) {
        $data = $request->validate([
            'pertanyaan' => 'required',
            'media_files' => 'nullable|array|max:5',
            'media_files.*' => 'file|mimes:jpg,jpeg,png,mp4,webm|max:20480', // max 20MB
            'opsi_a' => 'required',
            'opsi_b' => 'required',
            'opsi_c' => 'required',
            'opsi_d' => 'required',
            'opsi_e' => 'nullable',
            'jawaban_benar' => 'required|in:A,B,C,D,E'
        ]);

        $mediaPaths = [];
        if ($request->hasFile('media_files')) {
            foreach ($request->file('media_files') as $file) {
                $mediaPaths[] = $file->store('soal_media', 'public');
            }
        }
        $data['media_files'] = count($mediaPaths) > 0 ? $mediaPaths : null;

        $data['ujian_id'] = $ujian_id;
        Soal::create($data);
        return redirect()->route('guru.ujian.show', $ujian_id)->with('success', 'Soal berhasil ditambahkan');
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
        return redirect()->route('guru.ujian.show', $ujian_id)->with('success', 'Soal berhasil diperbarui');
    }
    public function destroy($ujian_id, $id) {
        Soal::destroy($id);
        return redirect()->route('guru.ujian.show', $ujian_id);
    }
}