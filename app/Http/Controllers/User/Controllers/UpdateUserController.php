<?php

namespace App\Http\Controllers\User\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Validation\Rule;

class UpdateUserController extends Controller
{

    public function update(Request $request, $token)
    {
        $alert = 'No se pudo actualizar, intenta nuevamente';
        $status = false;
        $data = [];
        $messages = [];

        $validator = $this->validateData($request->all());

        if ($validator['status'] == false) {

            $messages = $validator['messages'];

        } else {
            
            $user_id    = PersonalAccessToken::findToken($token)->first()->tokenable_id;
            $user       = User::find($user_id);

            if (Hash::check($request->oldPasword,$user->password)) {

                $user->password = bcrypt($request->newpassword);
                $user->update();
                $alert  = 'La contraseña se actualizo con exito.';
                $status = true;
            
            }else{
            
                $alert = 'La contraseña antigua no coincide.';
            
            }



            
        }

        return [
            'alert'     =>  $alert,
            'messages'  =>  $messages,
            'status'    =>  $status,
            'data'      =>  $data
        ];
    }

    public function updateEstadoUSer(Request $request){

        $alert = 'No se pudo actualizar el estado del usuario, intenta nuevamente';
        $status = false;
        $data = [];
        $messages = [];

        $validator = Validator::make(

            $request->all(),
            [
                'estado_users' => ['required', 'numeric', Rule::exists('estado_users', 'id')],
                'user_id'      => ['required', 'numeric', Rule::exists('users', 'id')]
            ],
            [
                'estado_users.required' => 'El id del Estado es requerido',
                'estado_users.numeric'  => 'El id del Estado es numerico',
                'estado_users.exists'   => 'El id del Estado no existe',
                'user_id.required'      => 'El id del Usuario es requerido',
                'user_id.numeric'       => 'El id del Usuario es numerico',
                'user_id.exists'        => 'El id del Usuario no existe'
            ]
        );

        if ($validator->fails()) {

            $messages = $validator->errors()->all();
        
        }else{

            $user = User::find($request->user_id);
            $user->estado_users = $request->estado_users;
            $user->update();

            $status=true;
            $alert= 'Se a actualizado el estado del usuario';

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
            'oldPasword.required'                     =>  'La antigua contraseña es requerida.',
            'newpassword.regex'                       =>  'La contraseña debe tener al menos 6 caracteres, incluyendo al menos una letra mayúscula, una letra minúscula y un número.',
            'newpassword.required'                    =>  'La nueva contraseña es requerida.',
            'repeat_password.required'                =>  'La repetición de contraseña es requerida.',
        ];
        $validate = [
            'newpassword'             => ['required', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/'],
            'oldPasword'              =>  'required',
            'repeat_password'         =>  'required'
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
