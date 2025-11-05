<?php

namespace App\Mail;

use App\Models\Certificate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CertificateForSigning extends Mailable
{
    use Queueable, SerializesModels;

    public Certificate $certificate;

    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }

    public function build()
    {
        $user = $this->certificate->user;
        $course = $this->certificate->course;

        $email = $this->subject('Certyfikat do podpisu kwalifikowanego — ' . $user->name)
            ->view('emails.certificate-for-signing', [
                'certificate' => $this->certificate,
                'user' => $user,
                'course' => $course,
            ]);

        if ($this->certificate->pdf_path && Storage::disk('public')->exists($this->certificate->pdf_path)) {
            $email->attach(Storage::disk('public')->path($this->certificate->pdf_path), [
                'as' => 'certyfikat-' . $this->certificate->certificate_number . '.pdf',
                'mime' => 'application/pdf',
            ]);
        }

        return $email;
    }
}


