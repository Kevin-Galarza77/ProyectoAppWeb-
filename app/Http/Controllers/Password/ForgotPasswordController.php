<?php

namespace App\Http\Controllers\Password;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Mail\MailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class ForgotPasswordController extends Controller
{
    public function forgot(Request $request)
    {
        DB::table('password_resets')->truncate();

        $status = false;
        $alert = 'Se ha producido un error al enviar el mail';
        $messages = [];

        $validator = Validator::make(
            $request->all(),
            ['email' => 'required|email'],
            ['email.required' => 'El email es requerido','email.email' => 'El email no tiene formato']
        );
    

        if ($validator->fails()) {
            
            $messages = $validator->errors()->all();

        } else {

            $token = Str::random(80);
            $createdAt = now();

            if (User::where('email',$request->email)->first() == null ) {

                $alert = 'Usuario no encontrado';

            }else{

                DB::table('password_resets')->insert([
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => $createdAt
                ]);
    
    
    
    
                $this->sendEmail($request->email,$token);
    
                $alert = 'Se ha enviado el link para restablecer tu contraseña';
                $status = true;

            }



        
        }

        return [
            'alert'     =>  $alert,
            'status'    =>  $status,
            'messages'  =>  $messages
        ];

    }


    public function sendEmail($mail,$token){
   
        $mail = new MailController($mail,$token);
        $mail->senMail();
           
    }

}
