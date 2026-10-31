<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\TahunAjaran;

class UjianController extends Controller {
    public function index() {
        if (auth()->user()->role === 'admin') {
            $data = Ujian::with(['mataPelajaran', 'kelas', 'tahunAjaran', 'guru'])->get();
        } else {
            $data = Ujian::with(['mataPelajaran', 'kelas', 'tahunAjaran'])->where('guru_id', auth()->id())->get();
        }
        return view('guru.ujian.index', compact('data'));
    }
    public function create() {
        $mapels = MataPelajaran::all();
        $kelas = Kelas::all();
        $tahun = TahunAjaran::all();
        return view('guru.ujian.create', compact('mapels', 'kelas', 'tahun'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'nama_ujian' => 'required|string|max:255',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'durasi' => 'required|integer|min:1',
            'waktu_mulai' => 'required|date',
        ]);
        $data['waktu_selesai'] = date('Y-m-d H:i:s', strtotime($data['waktu_mulai'] . ' + ' . $data['durasi'] . ' minutes'));
        $data['guru_id'] = auth()->id();
        Ujian::create($data);
        return redirect()->route(auth()->user()->role . '.ujian.index')->with('success', 'Ujian berhasil ditambahkan');
    }
    public function edit($id) {
        $data = Ujian::findOrFail($id);
        $mapels = MataPelajaran::all();
        $kelas = Kelas::all();
        $tahun = TahunAjaran::all();
        return view('guru.ujian.edit', compact('data', 'mapels', 'kelas', 'tahun'));
    }
    public function update(Request $request, $id) {
        $data = $request->validate([
            'nama_ujian' => 'required|string|max:255',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'durasi' => 'required|integer|min:1',
            'waktu_mulai' => 'required|date',
        ]);
        $data['waktu_selesai'] = date('Y-m-d H:i:s', strtotime($data['waktu_mulai'] . ' + ' . $data['durasi'] . ' minutes'));
        Ujian::findOrFail($id)->update($data);
        return redirect()->route(auth()->user()->role . '.ujian.index')->with('success', 'Ujian berhasil diperbarui');
    }
    public function destroy($id) {
        Ujian::destroy($id);
        return redirect()->route(auth()->user()->role . '.ujian.index');
    }
    public function show($id) {
        $ujian = Ujian::with('soals')->findOrFail($id);
        return view('guru.ujian.show', compact('ujian'));
    }

    public function indexSiswa() {
        $data = Ujian::with(['mataPelajaran', 'guru'])
            ->where('kelas_id', auth()->user()->kelas_id)
            ->get();
        
        // Auto-finish exams that have timed out
        $pesertas = \App\Models\PesertaUjian::where('siswa_id', auth()->id())
            ->where('status', 'mengerjakan')
            ->get();
            
        foreach($pesertas as $peserta) {
            $ujian = Ujian::find($peserta->ujian_id);
            if($ujian) {
                $endTime = \Carbon\Carbon::parse($peserta->waktu_mulai_mengerjakan)->addMinutes($ujian->durasi);
                if(now()->greaterThanOrEqualTo($endTime)) {
                    $this->prosesSelesai($peserta, $ujian);
                }
            }
        }

        return view('siswa.ujian.index', compact('data'));
    }
    public function mulai($id) {
        $ujian = Ujian::findOrFail($id);
        
        if ($ujian->kelas_id != auth()->user()->kelas_id) {
            abort(403, 'Anda tidak berhak mengakses ujian ini.');
        }

        $peserta = \App\Models\PesertaUjian::firstOrCreate([
            'ujian_id' => $id,
            'siswa_id' => auth()->id()
        ], [
            'waktu_mulai_mengerjakan' => now(),
            'status' => 'mengerjakan'
        ]);
        return redirect()->route('siswa.ujian.kerjakan', $id);
    }
    public function kerjakan($id) {
        $ujian = Ujian::with('soals')->findOrFail($id);

        if ($ujian->kelas_id != auth()->user()->kelas_id) {
            abort(403, 'Anda tidak berhak mengakses ujian ini.');
        }

        $peserta = \App\Models\PesertaUjian::where('ujian_id', $id)->where('siswa_id', auth()->id())->firstOrFail();
        
        // Auto-finish if time is up
        $endTime = \Carbon\Carbon::parse($peserta->waktu_mulai_mengerjakan)->addMinutes($ujian->durasi);
        if($peserta->status == 'mengerjakan' && now()->greaterThanOrEqualTo($endTime)) {
            $this->prosesSelesai($peserta, $ujian);
            return redirect()->route('siswa.ujian.index')->with('error', 'Waktu ujian sudah habis dan diselesaikan secara otomatis.');
        }

        if($peserta->status == 'selesai') return redirect()->route('siswa.ujian.index')->with('error', 'Sudah selesai');
        $jawabans = \App\Models\JawabanSiswa::where('peserta_ujian_id', $peserta->id)->pluck('jawaban', 'soal_id');
        return view('siswa.ujian.kerjakan', compact('ujian', 'peserta', 'jawabans'));
    }
    public function simpanJawaban(Request $request, $id) {
        $peserta = \App\Models\PesertaUjian::where('ujian_id', $id)->where('siswa_id', auth()->id())->firstOrFail();

        if ($peserta->status === 'selesai') {
            return response()->json(['success' => false, 'message' => 'Ujian sudah selesai.'], 403);
        }

        // Soal harus milik ujian ini
        $soal = \App\Models\Soal::where('ujian_id', $id)->findOrFail($request->input('soal_id'));

        if ($soal->isEsai()) {
            $request->validate(['jawaban' => 'nullable|string|max:20000']);
        } else {
            $request->validate(['jawaban' => 'nullable|in:A,B,C,D,E']);
        }

        \App\Models\JawabanSiswa::updateOrCreate([
            'peserta_ujian_id' => $peserta->id,
            'soal_id' => $soal->id
        ], [
            'jawaban' => $request->input('jawaban')
        ]);
        return response()->json(['success' => true]);
    }
    public function selesai($id) {
        $peserta = \App\Models\PesertaUjian::where('ujian_id', $id)->where('siswa_id', auth()->id())->firstOrFail();
        $ujian = Ujian::with('soals')->findOrFail($id);
        
        if($peserta->status == 'selesai') {
             return redirect()->route('siswa.ujian.index')->with('error', 'Ujian sudah diselesaikan sebelumnya.');
        }

        $hasil = $this->prosesSelesai($peserta, $ujian);
        $pesan = 'Ujian selesai. Nilai: ' . number_format($hasil->nilai_akhir, 0);
        if ($hasil->esai_belum_dinilai > 0) {
            $pesan .= ' (sementara, ' . $hasil->esai_belum_dinilai . ' soal esai menunggu dikoreksi guru)';
        }
        return redirect()->route('siswa.ujian.index')->with('success', $pesan);
    }

    private function prosesSelesai($peserta, $ujian) {
        $peserta->update(['status' => 'selesai', 'waktu_selesai_mengerjakan' => now()]);

        // Load soals if not loaded
        if (!$ujian->relationLoaded('soals')) {
            $ujian->load('soals');
        }

        // Penilaian (pilihan ganda otomatis, esai menunggu koreksi guru)
        return \App\Models\HasilUjian::hitung($peserta, $ujian);
    }
}