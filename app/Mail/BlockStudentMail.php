<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class BlockStudentMail extends Mailable
{
    use Queueable, SerializesModels;

    private $siswa;

    public function __construct(array $siswa)
    {
        $this->siswa = $siswa;
    }

    public function content()
    {
        return new Content(
            view: 'emails.block',
            with: [
                'siswa' => $this->siswa,
                'tanggal' => now()->translatedFormat('l, d F Y')
            ]
        );
    }
}
