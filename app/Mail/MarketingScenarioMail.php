<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MarketingScenarioMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $subjectLine,
        public string $body
    ) {
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
            ->view('emails.marketing-scenario', [
                'body' => $this->body,
            ]);
    }
}
