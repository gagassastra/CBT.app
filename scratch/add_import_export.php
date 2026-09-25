<?php
$f = 'd:/PKBM AL QUDWAH/Penilaian/app/Http/Controllers/SiswaDataController.php';
$c = file_get_contents($f);
$c = preg_replace('/}\s*$/', '', $c); // remove last brace

$methods = <<<'EOD'

    public function exportCsv()
    {
        $siswa = User::where('role', 'siswa')->get();
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=Data_Siswa.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Nama', 'Email', 'Tempat Lahir', 'Tanggal Lahir');

        $callback = function() use($siswa, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($siswa as $s) {
                fputcsv($file, array($s->name, $s->email, $s->tempat_lahir, $s->tanggal_lahir));
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

        $file = $request->file('file');
        $handle = fopen($file->getPathname(), "r");
        
        $header = true;
        $count = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($header) {
                $header = false;
                continue;
            }
            
            // Expected columns: Nama, Email, Tempat Lahir, Tanggal Lahir
            $name = $data[0] ?? '';
            $email = $data[1] ?? '';
            $tempat = $data[2] ?? null;
            $tanggal = $data[3] ?? null;
            
            if(!empty($email) && !empty($name)) {
                // Check if exists
                $user = User::where('email', $email)->first();
                if(!$user) {
                    User::create([
                        'name' => $name,
                        'email' => $email,
                        'tempat_lahir' => $tempat,
                        'tanggal_lahir' => $tanggal ? date('Y-m-d', strtotime($tanggal)) : null,
                        'role' => 'siswa',
                        'password_plain' => 'AL_QUDWAH',
                        'password' => bcrypt('AL_QUDWAH'),
                    ]);
                    $count++;
                }
            }
        }
        fclose($handle);

        return redirect()->route('admin.siswa.index')->with('success', $count . ' Siswa berhasil diimpor!');
    }
}
EOD;

file_put_contents($f, $c . $methods);
echo 'Added export and import methods';
