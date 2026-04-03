<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\HtmlString; // Tambahin ini biar bisa pakai tag HTML (br) di tanda tangan

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            return (new MailMessage)
                ->subject('Permohonan Pengaturan Ulang Kata Sandi - Karir Sukun')
                ->greeting('Yth. Kandidat,')
                ->line('Kami menerima permohonan untuk mengatur ulang kata sandi (reset password) pada akun Karir Sukun Anda.')
                ->action('Atur Ulang Kata Sandi', url(route('password.reset', [
                    'token' => $token,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ], false)))
                ->line('Jika Anda tidak merasa melakukan permohonan ini, mohon abaikan pesan ini. Akun Anda akan tetap aman dan tidak ada tindakan lebih lanjut yang diperlukan.')
                ->salutation(new HtmlString('Hormat kami,<br><strong>Tim Rekrutmen HRD Sukun</strong>'));
        });
    }
}