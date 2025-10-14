<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Content;

class ResetPasswordPolish extends BaseResetPassword
{
    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $url = route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);

        // Pobierz treści z CMS
        $subject = Content::getByKey('emails.reset_password.subject') ?? 'Resetowanie hasła - Lekam Akademia';
        $greeting = Content::getByKey('emails.reset_password.greeting') ?? 'Cześć!';
        $intro = Content::getByKey('emails.reset_password.intro') ?? 'Otrzymujesz ten email, ponieważ otrzymaliśmy prośbę o zresetowanie hasła dla Twojego konta.';
        $buttonText = Content::getByKey('emails.reset_password.button_text') ?? 'Resetuj hasło';
        $expiryMinutes = config('auth.passwords.'.config('auth.defaults.passwords').'.expire');
        $expiryInfo = Content::getByKey('emails.reset_password.expiry_info') ?? 'Ten link wygaśnie za :count minut.';
        $expiryInfo = str_replace(':count', $expiryMinutes, $expiryInfo);
        $footer = Content::getByKey('emails.reset_password.footer') ?? 'Jeśli nie prosiłeś o zresetowanie hasła, zignoruj tę wiadomość.';
        $signature = Content::getByKey('emails.reset_password.signature') ?? 'Zespół Lekam Akademia';

        return (new MailMessage)
            ->subject($subject)
            ->greeting($greeting)
            ->line($intro)
            ->action($buttonText, $url)
            ->line($expiryInfo)
            ->line($footer)
            ->salutation($signature);
    }
}