<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailPolish extends BaseVerifyEmail
{
    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Potwierdź swój adres email - Lekam Akademia')
            ->greeting('Cześć!')
            ->line('Kliknij poniższy przycisk, aby potwierdzić swój adres email.')
            ->action('Potwierdź adres email', $verificationUrl)
            ->line('Jeśli nie zarejestrowałeś się w naszej akademii, zignoruj tę wiadomość.')
            ->salutation('Zespół Lekam Akademia');
    }
}