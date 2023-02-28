<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Mail\sendMail;
use Illuminate\Support\Facades\Mail;
class MailController extends Controller
{
    public function senMail(){
        $data = ['name' => ', se a creado un nuevo producto al CRUD Laravel!!'];
        Mail::to('jimenezkevin1040@gmail.com')->send(new sendMail($data));
        dd($data);
    }
}
