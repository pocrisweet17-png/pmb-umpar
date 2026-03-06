<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class VerifyRegistrationMail extends Mailable
{
    public $nama;
    public $nomor_registrasi;
     public $verificationUrl;

    public function __construct($nama, $nomor_registrasi,$verificationUrl)
    {
        $this->nama = $nama;
        $this->nomor_registrasi = $nomor_registrasi;
         $this->verificationUrl = $verificationUrl;
    }

    public function build()
    {
        return $this->subject('Verifikasi Email Pendaftaran Anda')
                    ->view('emails.verify-registration');
    }
}
