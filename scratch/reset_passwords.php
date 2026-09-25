<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$users = User::where('role', 'siswa')->get();
foreach($users as $user) {
    $user->password_plain = 'AL_QUDWAH';
    $user->password = bcrypt('AL_QUDWAH');
    $user->save();
}
echo "Berhasil mengatur ulang password " . $users->count() . " siswa menjadi AL_QUDWAH.";
