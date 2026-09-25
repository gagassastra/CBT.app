<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\HasilUjian;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        // Get all exams created by this guru
        $data = Ujian::with(['mataPelajaran', 'kelas'])->where('guru_id', auth()->id())->get();
        return view('guru.laporan.index', compact('data'));
    }

    public function show($id)
    {
        $ujian = Ujian::with(['mataPelajaran', 'kelas', 'guru', 'pesertaUjians.siswa', 'pesertaUjians.hasilUjian'])
                    ->where('guru_id', auth()->id())
                    ->findOrFail($id);

        return view('guru.laporan.show', compact('ujian'));
    }

    public function cetakPdf($id)
    {
        $ujian = Ujian::with(['mataPelajaran', 'kelas', 'guru', 'pesertaUjians.siswa', 'pesertaUjians.hasilUjian'])
                    ->where('guru_id', auth()->id())
                    ->findOrFail($id);
                    
        $pdf = Pdf::loadView('guru.laporan.pdf', compact('ujian'));
        
        // Optional: set paper size
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Laporan_Hasil_Nilai_' . str_replace(' ', '_', $ujian->nama_ujian) . '.pdf');
    }
}
