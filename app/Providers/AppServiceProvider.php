<?php

namespace App\Providers;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Support\ServiceProvider;

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
            ->subject('Permintaan Reset Password - Sukun Karir')
            ->greeting('Halo!')
            ->line('Kami menerima permintaan untuk mereset password akun Sukun Karir kamu.')
            ->action('Buat Password Baru', url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false)))
            ->line('Kalau kamu tidak pernah merasa meminta reset password, abaikan saja email ini.')
            ->salutation('Salam hangat, HRD Sukun');
    });
}
}
