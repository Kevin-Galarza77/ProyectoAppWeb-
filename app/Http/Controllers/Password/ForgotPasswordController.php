<?php

namespace App\Http\Controllers\Password;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Mail\MailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function forgot(Request $request)
    {

        $this->sendEmail();
        $request->validate(['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'));

        if ($response === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Correo electrónico enviado'], 200);
        } else {
            return response()->json(['message' => 'Correo electrónico no enviado'], 400);
        }
    }


    public function sendEmail(){
        
        $mail = new MailController();
        $mail->senMail();
        
        
    }

}
