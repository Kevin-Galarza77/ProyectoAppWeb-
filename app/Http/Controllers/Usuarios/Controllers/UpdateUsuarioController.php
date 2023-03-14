<?php

namespace App\Http\Controllers\Usuarios\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class UpdateUsuarioController extends Controller
{

    public function update(Request $request, $token)
    {

        $alert = 'No se pudo actualizar, intenta nuevamente';
        $status = false;
        $data = [];
        $messages = [];

        $user_id    = PersonalAccessToken::findToken($token)->first()->tokenable_id;
        $usuario    = usuarios::where('user_id', $user_id)->first();
        $user       = User::find($user_id);

        $validator = $this->validateData($request->all(), $user_id, $usuario->id);

        if ($validator['status'] == false) {

            $messages = $validator['messages'];

        } else {

            $user->email      = $request['email'];
            $user->updated_at = now('America/Guayaquil')->format('Y-m-d H:i:s');
            $user->update();

            $usuario->CI_Usuario                = $request['CI_Usuario'];
            $usuario->Nombre_Usuario            = $request['Nombre_Usuario'];
            $usuario->FechaNacimiento_Usuario   = $request['FechaNacimiento_Usuario'];
            $usuario->Cel_Usuario               = $request['Cel_Usuario'];
            $usuario->Direccion_Usuario         = $request['Direccion_Usuario'];
            $usuario->update();

            $status = true;
            $alert = 'El usuario se ha actualizado con exito';
        }

        return [
            'alert'     =>  $alert,
            'messages'  =>  $messages,
            'status'    =>  $status,
            'data'      =>  $data
        ];
    }


    public function validateData($data, $user_id, $usuario_id)
    {
        $status = true;
        $messages = [
            'email.required'                    =>  'El email es requerido.',
            'email.email'                       =>  'El correo electrónico debe estar escrito en un formato correcto',
            'email.unique'                      =>  'El correo electrónico ya se encuentra registrado.',
            'CI_Usuario.required'               =>  'El número de Cédula del usuario es requerido.',
            'CI_Usuario.numeric'                =>  'El número de Cédula debe tener solo digitos (números).',
            'CI_Usuario.digits'                 =>  'El número de Cédula debe tener 10 digitos.',
            'CI_Usuario.unique'                 =>  'El número de Cédula ya se encuentra registrado.',
            'Nombre_Usuario.required'           =>  'El nombre del usuario es requerido.',
            'FechaNacimiento_Usuario.required'  =>  'La fecha de nacimiento del usuario es requerida.',
            'Cel_Usuario.required'              =>  'El Célular del usuario es requerido',
            'Cel_Usuario.numeric'               =>  'El Célular del usuario debe tener solo digitos (números).',
            'Cel_Usuario.digits'                =>  'El Célular del usuario debe tener 10 digitos.',
            'Cel_Usuario.unique'                =>  'El Célular ya se encuentra registrado.',
            'Direccion_Usuario.required'        =>  'Una direccion es requerida',
        ];
        $validate = [
            'email'                   =>  'required|email|unique:users,email,' . $user_id .',id',
            'CI_Usuario'              => 'required|numeric|digits:10|unique:usuarios,CI_Usuario,' . $usuario_id .',id',
            'Nombre_Usuario'          =>  'required',
            'FechaNacimiento_Usuario' =>  'required',
            'Cel_Usuario'              => 'required|numeric|digits:10|unique:usuarios,Cel_Usuario,' . $usuario_id .',id',
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
