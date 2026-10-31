<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\PesertaUjian;
use App\Models\HasilUjian;
use App\Models\JawabanSiswa;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $data = Ujian::with(['mataPelajaran', 'kelas', 'guru'])->get();
        } else {
            $data = Ujian::with(['mataPelajaran', 'kelas'])->where('guru_id', auth()->id())->get();
        }
        return view('guru.laporan.index', compact('data'));
    }

    public function show($id)
    {
        $query = Ujian::with(['mataPelajaran', 'kelas', 'guru', 'pesertaUjians.siswa', 'pesertaUjians.hasilUjian']);
        
        if (auth()->user()->role !== 'admin') {
            $query->where('guru_id', auth()->id());
        }

        $ujian = $query->findOrFail($id);

        return view('guru.laporan.show', compact('ujian'));
    }

    public function cetakPdf($id)
    {
        $query = Ujian::with(['mataPelajaran', 'kelas', 'guru', 'pesertaUjians.siswa', 'pesertaUjians.hasilUjian']);
        
        if (auth()->user()->role !== 'admin') {
            $query->where('guru_id', auth()->id());
        }

        $ujian = $query->findOrFail($id);
                    
        $pdf = Pdf::loadView('guru.laporan.pdf', compact('ujian'));
        
        // Optional: set paper size
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Laporan_Hasil_Nilai_' . str_replace(' ', '_', $ujian->nama_ujian) . '.pdf');
    }

    /**
     * Halaman koreksi soal esai milik seorang peserta.
     */
    public function koreksi($peserta_id)
    {
        [$peserta, $ujian] = $this->pesertaDanUjian($peserta_id);

        $soals = $ujian->soals()->where('tipe', 'esai')->orderBy('id')->get();
        $jawabans = JawabanSiswa::where('peserta_ujian_id', $peserta->id)
            ->whereIn('soal_id', $soals->pluck('id'))
            ->get()->keyBy('soal_id');
        $peserta->load('siswa', 'hasilUjian');

        return view('guru.laporan.koreksi', compact('ujian', 'peserta', 'soals', 'jawabans'));
    }

    public function simpanKoreksi(Request $request, $peserta_id)
    {
        [$peserta, $ujian] = $this->pesertaDanUjian($peserta_id);

        $request->validate([
            'skor' => 'nullable|array',
            'skor.*' => 'nullable|numeric|min:0',
        ]);

        $soals = $ujian->soals()->where('tipe', 'esai')->get()->keyBy('id');
        $jawabans = JawabanSiswa::where('peserta_ujian_id', $peserta->id)
            ->whereIn('soal_id', $soals->keys())
            ->get();

        foreach ($jawabans as $jawab) {
            $input = $request->input('skor.' . $jawab->id);
            if ($input === null || $input === '') {
                $jawab->update(['skor' => null]); // dikosongkan = belum dinilai
                continue;
            }
            $maks = max(0, (float) ($soals[$jawab->soal_id]->bobot ?? 1));
            $jawab->update(['skor' => min((float) $input, $maks)]);
        }

        HasilUjian::hitung($peserta, $ujian);

        return redirect()->route(auth()->user()->role . '.laporan.show', $ujian->id)->with('success', 'Koreksi esai berhasil disimpan.');
    }

    /** Ambil peserta + ujian, dan pastikan guru hanya mengakses ujiannya sendiri. */
    private function pesertaDanUjian($peserta_id): array
    {
        $peserta = PesertaUjian::findOrFail($peserta_id);
        $ujian = Ujian::findOrFail($peserta->ujian_id);

        if (auth()->user()->role === 'guru' && $ujian->guru_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        return [$peserta, $ujian];
    }

    public function reset($peserta_id)
    {
        $peserta = PesertaUjian::findOrFail($peserta_id);
        $ujian = Ujian::findOrFail($peserta->ujian_id);

        // Verify ownership for guru
        if (auth()->user()->role === 'guru' && $ujian->guru_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete related answers and results
        JawabanSiswa::where('peserta_ujian_id', $peserta->id)->delete();
        HasilUjian::where('peserta_ujian_id', $peserta->id)->delete();
        
        // Delete the peserta entry to allow the student to start over
        $peserta->delete();

        return back()->with('success', 'Ujian siswa berhasil direset.');
    }
}
