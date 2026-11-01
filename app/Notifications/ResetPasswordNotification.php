<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Email reset kata sandi berbahasa Indonesia.
 * Tautan reset dikirim ke kotak masuk email pengguna.
 */
class ResetPasswordNotification extends BaseResetPassword
{
    public function toMail($notifiable): MailMessage
    {
        $url = $this->resetUrl($notifiable);
        $expire = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire');

        return (new MailMessage)
            ->subject('Atur Ulang Kata Sandi - ' . config('app.name'))
            ->greeting('Halo, ' . ($notifiable->name ?? 'Pengguna') . '!')
            ->line('Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda di ' . config('app.name') . '.')
            ->action('Atur Ulang Kata Sandi', $url)
            ->line('Tautan ini hanya berlaku selama ' . $expire . ' menit.')
            ->line('Jika Anda tidak merasa meminta pengaturan ulang kata sandi, abaikan email ini. Kata sandi Anda tidak akan berubah.')
            ->salutation('Salam, ' . config('app.name'));
    }
}

