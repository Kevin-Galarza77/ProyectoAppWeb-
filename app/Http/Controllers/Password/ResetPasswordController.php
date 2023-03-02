<?php

namespace App\Http\Controllers\Password;

use App\Http\Controllers\Controller;
use App\Models\User;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    public function reset(Request $request)
    {

        $status = false;
        $alert = 'Se ha producido un error al cambiar la contraseña';
        $messages = [];


        $validator = Validator::make(
            $request->all(),
            ['email'           => 'required|email',
             'token'           => 'required',
            'password'         => ['required', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/'],
            'repeat_password'  => 'required|same:password'
            ],
            ['email.required'           => 'El email es requerido', 
            'email.email'               => 'El email no tiene formato',
            'password.required'         => 'La contraseña es requerida.',
            'password.regex'            => 'La contraseña debe tener al menos 6 caracteres, incluyendo al menos una letra mayúscula, una letra minúscula y un número.',
            'repeat_password.required'  => 'La contraseña repetida es requerida.',
            'repeat_password.same'      => 'Las contraseñas no coiniciden.',
            'token.required'            => 'El token es requerido'
            ]
        );

        if ($validator->fails()) {

            $messages = $validator->errors()->all();

        } else{
            $registro = DB::table('password_resets')->where('email', $request->email);
            $registro2 = DB::table('password_resets')->where('token', $request->token);
            if ($registro->exists() && $registro2->exists()) {
                $date = new DateTime('now', new DateTimeZone('America/Guayaquil'));
                $user = User::where('email', $request->email)->first();
                $user->password = bcrypt($request->password);
                $user->updated_at = $date->format('Y-m-d H:i:s');
                $user->update();

                $alert = 'Contraseña cambiada con exito.';
                $status = true;
                $registro->delete();
                
            }else{
                $alert = 'Usuario no encontrado con solicitud de cambio de contraseña o Token no válido';
            }

        }
 

  


        return [
            'alert'     =>  $alert,
            'status'    =>  $status,
            'messages'  =>  $messages
        ];

    }
}
