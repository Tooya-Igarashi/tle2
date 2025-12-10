<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Submitted;

class SubmittedMail extends Mailable
{
    public function __construct(public Submitted $submitted)
    {
    }

    public function build()
    {
        return $this->subject('Nieuwe challenge inzending')
            ->view('emails.submitted');
    }
}

