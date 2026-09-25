<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kelas;

class SiswaDataController extends Controller
{
    public function index()
    {
        $data = User::with('kelas')->where('role', 'siswa')->get();
        return view('admin.siswa.index', compact('data'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|string|unique:users,nisn',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'kelas_id' => 'required|exists:kelas,id',
        ]);
        
        $data['password_plain'] = 'AL_QUDWAH';
        $data['password'] = bcrypt('AL_QUDWAH');
        $data['role'] = 'siswa';
        
        User::create($data);
        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = User::where('role', 'siswa')->findOrFail($id);
        $kelas = Kelas::all();
        return view('admin.siswa.edit', compact('data', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $user = User::where('role', 'siswa')->findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|string|unique:users,nisn,'.$id,
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'kelas_id' => 'required|exists:kelas,id',
        ]);
        
        $user->update($data);
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::where('role', 'siswa')->findOrFail($id);
        $user->delete();
        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus');
    }

    public function cetakKartu($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);
        
        // 7 cm x 5 cm to points (1 cm = 28.346 pt)
        // Width: 7 * 28.346 = 198.422
        // Height: 5 * 28.346 = 141.73
        // Landscape meaning we set paper to array(0, 0, 198.422, 141.73)
        $customPaper = array(0, 0, 198.422, 141.73);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.siswa.kartu', compact('siswa'))
            ->setPaper($customPaper);

        return $pdf->download('Kartu_Siswa_' . str_replace(' ', '_', $siswa->name) . '.pdf');
    }

    public function cetakSemuaKartu()
    {
        $siswa = User::where('role', 'siswa')->get();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.siswa.kartu_semua', compact('siswa'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('Kartu_Semua_Siswa.pdf');
    }

    public function exportCsv()
    {
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=Template_Data_Siswa.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Nama', 'NISN', 'Tempat Lahir', 'Tanggal Lahir (YYYY-MM-DD)', 'ID Kelas');
        $kelas = \App\Models\Kelas::all();

        $callback = function() use($columns, $kelas) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            // Contoh pengisian
            $contohKelasId = $kelas->first()->id ?? 1;
            fputcsv($file, array('Contoh Siswa', '1234567890', 'Jakarta', '2005-01-01', $contohKelasId));
            
            // Jarak
            fputcsv($file, array());
            
            // Referensi Kelas
            fputcsv($file, array('--- REFERENSI ID KELAS (Boleh Dihapus) ---', '', '', '', ''));
            fputcsv($file, array('ID Kelas', 'Nama Kelas', '', '', ''));
            foreach ($kelas as $k) {
                fputcsv($file, array($k->id, $k->nama_kelas, '', '', ''));
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        // Tambah batas waktu eksekusi agar tidak timeout untuk 500+ siswa
        set_time_limit(300);

        $file = $request->file('file');
        $handle = fopen($file->getPathname(), "r");
        
        $header = true;
        
        // Optimasi: Buat password sekali saja di luar loop
        $defaultPassword = bcrypt('AL_QUDWAH');
        
        // Optimasi: Ambil semua ID kelas yang valid
        $validKelasIds = \App\Models\Kelas::pluck('id')->toArray();
        
        // Optimasi: Ambil semua NISN yang sudah ada di database untuk mencegah query per baris
        $existingNisn = User::whereNotNull('nisn')->pluck('nisn')->toArray();
        $existingNisnMap = array_flip($existingNisn); // Untuk pencarian O(1)

        $insertData = [];
        $now = now();
        $count = 0;

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($header) {
                $header = false;
                continue;
            }
            
            // Expected columns: Nama, NISN, Tempat Lahir, Tanggal Lahir, ID Kelas
            $name = $data[0] ?? '';
            $nisn = $data[1] ?? '';
            $tempat = $data[2] ?? null;
            $tanggal = $data[3] ?? null;
            $kelas_id = $data[4] ?? null;
            
            // Skip empty rows or reference rows
            if(empty($nisn) || empty($name) || !is_numeric($nisn)) {
                continue;
            }

            // Validasi kelas_id tanpa query ke DB
            if (!empty($kelas_id) && !in_array($kelas_id, $validKelasIds)) {
                $kelas_id = null; // Set null jika ID kelas tidak ada di database
            }

            // Cek apakah NISN sudah ada (dari array, bukan DB)
            if(!isset($existingNisnMap[$nisn])) {
                $insertData[] = [
                    'name' => $name,
                    'nisn' => $nisn,
                    'tempat_lahir' => $tempat,
                    'tanggal_lahir' => $tanggal ? date('Y-m-d', strtotime($tanggal)) : null,
                    'kelas_id' => $kelas_id,
                    'role' => 'siswa',
                    'password_plain' => 'AL_QUDWAH',
                    'password' => $defaultPassword,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
                
                // Tambahkan ke map agar tidak ada duplikat dalam file CSV yang sama
                $existingNisnMap[$nisn] = true;
                $count++;
            }
        }
        fclose($handle);

        // Optimasi: Insert massal (dibagi per 100 agar query tidak terlalu besar)
        foreach (array_chunk($insertData, 100) as $chunk) {
            User::insert($chunk);
        }

        return redirect()->route('admin.siswa.index')->with('success', $count . ' Siswa berhasil diimpor!');
    }
}