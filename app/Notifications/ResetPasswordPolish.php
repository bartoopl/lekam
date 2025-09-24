<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordPolish extends BaseResetPassword
{
    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $url = url(config('app.url').route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Resetowanie hasła - Lekam Akademia')
            ->greeting('Cześć!')
            ->line('Otrzymujesz ten email, ponieważ otrzymaliśmy prośbę o zresetowanie hasła dla Twojego konta.')
            ->action('Resetuj hasło', $url)
            ->line('Ten link wygaśnie za :count minut.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')])
            ->line('Jeśli nie prosiłeś o zresetowanie hasła, zignoruj tę wiadomość.')
            ->salutation('Zespół Lekam Akademia');
    }
}