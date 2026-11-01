<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     * Tautan reset dikirim ke email yang terdaftar pada akun.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
        ]);

        try {
            $status = Password::sendResetLink($request->only('email'));
        } catch (\Throwable $e) {
            // Gagal mengirim email (mis. konfigurasi SMTP salah) - jangan tampilkan error 500.
            Log::error('Gagal mengirim email reset password: ' . $e->getMessage());

            return back()->withInput($request->only('email'))->withErrors([
                'email' => 'Email belum dapat dikirim saat ini. Silakan coba lagi nanti atau hubungi administrator sekolah.',
            ]);
        }

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Tautan pengaturan ulang kata sandi telah dikirim ke email Anda. Silakan periksa kotak masuk (atau folder Spam), lalu klik tautan di dalam email.');
        }

        $pesan = match ($status) {
            Password::INVALID_USER => 'Email tersebut tidak terdaftar pada sistem. Siswa yang belum memiliki email dapat meminta reset kata sandi kepada administrator.',
            Password::RESET_THROTTLED => 'Permintaan terlalu sering. Mohon tunggu beberapa saat sebelum mencoba lagi.',
            default => 'Tautan reset kata sandi tidak dapat dikirim. Silakan coba lagi.',
        };

        return back()->withInput($request->only('email'))->withErrors(['email' => $pesan]);
    }
}
