<?php

namespace App\Mail;

use App\Models\Siswa;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $siswa;
    public $presensi;

    /**
     * Create a new message instance.
     */
    public function __construct(Siswa $siswa, $presensi)
    {
        $this->siswa = $siswa;
        $this->presensi = $presensi;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.presensi-approved')
            ->subject('Presensi Anda Telah Disetujui')
            ->with([
                'namaSiswa' => $this->siswa->nama,
                'presensi' => $this->presensi,
                'bukti' => ($this->presensi['jenis'] === 'I' || $this->presensi['jenis'] === 'S') ? $this->presensi['bukti'] : null,
            ]);
    }
}
