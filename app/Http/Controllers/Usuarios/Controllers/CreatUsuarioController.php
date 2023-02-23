<?php

namespace App\Http\Controllers\Usuarios\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreatUsuarioController extends Controller
{

    public function store(Request $request)
    {

        $alert = 'No se pudo crear la cuenta, intenta nuevamente';
        $status = false;
        $data = [];
        $messages = [];

        $validator = $this->validateData($request->all());

        if ($validator['status'] == false) {

            $messages = $validator['messages'];

        } else {

            if (User::where('email', $request->email)->first()!=null) {
                
                $messages=['Este email ya se encuentra registrado.'];

            }else if(usuarios::where('CI_Usuario', $request->CI_Usuario)->first()!=null){
                
                $messages=['Este número de Cédula ya se encuentra registrado.'];
            
            }else if(usuarios::where('Cel_Usuario', $request->Cel_Usuario)->first()!=null){

                $messages=['Este número de celular ya se encuentra registrado.'];
            
            }else{

                $user = new User;
                $user->email             = $request['email'];
                $user->email_verified_at = now('America/Guayaquil')->format('Y-m-d H:i:s');
                $user->password          = bcrypt($request['password']);
                $user->save();
    
                $usuario = new usuarios;
                $usuario->CI_Usuario                = $request['CI_Usuario'];
                $usuario->Nombre_Usuario            = $request['Nombre_Usuario'];
                $usuario->FechaNacimiento_Usuario   = $request['FechaNacimiento_Usuario'];
                $usuario->Cel_Usuario               = $request['Cel_Usuario'];
                $usuario->Direccion_Usuario         = $request['Direccion_Usuario'];
                $usuario->User_id                   = $user->id ;
                $usuario->save();
                
                $status=true;
                $alert='El usuario se ha registrado con exito';
            

            }

        }

        return [
            'alert'     =>  $alert,
            'messages'  =>  $messages,
            'status'    =>  $status,
            'data'      =>  $data
        ];
    }


    public function validateData($data)
    {
        $status = true;
        $messages = [
            'email.required'                    =>  'El email es requerido.',
            'email.email'                       =>  'El correo electrónico debe estar escrito en un formato correcto',
            'password.required'                 =>  'La contraseña es requerida.',
            'password.regex'                    =>  'La contraseña debe tener al menos 6 caracteres, incluyendo al menos una letra mayúscula, una letra minúscula y un número.',
            'repeat_password.required'          =>  'La contraseña repetida es requerida.',
            'repeat_password.same'              =>  'Las contraseñas no coiniciden.',
            'CI_Usuario.required'               =>  'El número de Cédula del usuario es requerido.',
            'CI_Usuario.numeric'                =>  'El número de Cédula debe tener solo digitos (números).',
            'CI_Usuario.digits'                 =>  'El número de Cédula debe tener 10 digitos.',
            'Nombre_Usuario.required'           =>  'El nombre del usuario es requerido.',
            'FechaNacimiento_Usuario.required'  =>  'La fecha de nacimiento del usuario es requerida.',
            'Cel_Usuario.required'              =>  'El Célular del usuario es requerido',
            'Cel_Usuario.numeric'               =>  'El Célular del usuario debe tener solo digitos (números).',
            'Cel_Usuario.digits'                =>  'El Célular del usuario debe tener 10 digitos.',
            'Direccion_Usuario.required'        =>  'Una direccion es requerida',
        ];

        $validate = [
            'email'                   =>  'required|email',
            'password'                => ['required', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/'],
            'repeat_password'         => 'required|same:password',
            'CI_Usuario'              =>  'required|numeric|digits:10',
            'Nombre_Usuario'          =>  'required',
            'FechaNacimiento_Usuario' =>  'required',
            'Cel_Usuario'             =>  'required|numeric|digits:10',
            'Direccion_Usuario'       =>  'required',
        ];

        $validator = Validator::make($data, $validate, $messages);

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $status = false;
        }

        return [
            'messages'   =>  $messages,
            'status'     =>  $status
        ];
    }
}
