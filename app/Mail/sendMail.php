<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;    
    }

    public function build(){
        return $this->from('jimenezkev1040@gmail.com', env('MAIL_FROM_NAME'))
            ->view('linkPassword')
            ->subject('Resetear Contraseña')
            ->with($this->data);
    }
}
