<?php

namespace App\Mail;

use App\Models\Siswa;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class KreditNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $siswa;
    public $nominal;

    /**
     * Create a new message instance.
     */
    public function __construct(Siswa $siswa, $nominal)
    {
        $this->siswa = $siswa;
        $this->nominal = $nominal;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.kredit-notification')
            ->subject('Debit Tabungan Anda Telah Ditambahkan')
            ->with([
                'namaSiswa' => $this->siswa->nama,
                'nominal' => $this->nominal,
            ]);
    }
}
