<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Mail\sendMail;
use Illuminate\Support\Facades\Mail;
class MailController extends Controller
{

    public $mail;
    public $token;

    public function __construct($mail,$token)
    {
        $this->mail = $mail;
        $this->token = $token;    
    }

    public function senMail(){
        $url='http://localhost:4200/Forgot-Password/'.$this->token;
        $data = ['mail' => $this->mail, 'token'=>$this->token, 'url'=>$url];
        Mail::to($this->mail)->send(new sendMail($data));
    }
}
