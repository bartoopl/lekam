<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Content;

class VerifyEmailPolish extends BaseVerifyEmail
{
    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        // Pobierz treści z CMS
        $subject = Content::getByKey('emails.verification.subject') ?? 'Potwierdź swój adres email - Lekam Akademia';
        $greeting = Content::getByKey('emails.verification.greeting') ?? 'Cześć!';
        $intro = Content::getByKey('emails.verification.intro') ?? 'Kliknij poniższy przycisk, aby potwierdzić swój adres email.';
        $buttonText = Content::getByKey('emails.verification.button_text') ?? 'Potwierdź adres email';
        $footer = Content::getByKey('emails.verification.footer') ?? 'Jeśli nie zarejestrowałeś się w naszej akademii, zignoruj tę wiadomość.';
        $signature = Content::getByKey('emails.verification.signature') ?? 'Zespół Lekam Akademia';

        return (new MailMessage)
            ->subject($subject)
            ->greeting($greeting)
            ->line($intro)
            ->action($buttonText, $verificationUrl)
            ->line($footer)
            ->salutation($signature);
    }
}