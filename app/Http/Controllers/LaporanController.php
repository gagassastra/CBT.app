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
