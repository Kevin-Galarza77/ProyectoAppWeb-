<?php

namespace App\Http\Controllers\User\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreatUserController extends Controller
{

    public function store(Request $request)
    {
        $alert = 'No se pudo crear el usuario, intenta nuevamente';
        $status = false;
        $data = null;
        $messages = null;

        $validator = $this->validateData($request->all());

        if($validator['status'] == false)
        {
            $messages = $validator['messages'];
            
        }else{
            
        }










    }


    public function validateData($data)
    {
        $status = true;
        $messages = [
            'email.required'            =>  'El email es requerido.',
            'email.email'               =>  'El correo electrónico debe estar escrito en un formáto correcto',
            'password.required'         =>  'La contraseña es requerida.',
            'CI_Usuario.required'       =>  'El numero de cedula del usuario es requerido.',
            'Nombre_Usuario.required'   =>  'El nombre del usuario es requerido.',
            'FechaNacimiento_Usuario.required'  =>  'La fecha de nacimiento del usuario es requerida.',
            'Cel_Usuario.required'      =>  'El número de celular es requerido',
        ];

        $validate = [
            'email'             =>  'required|email',
            'password'          =>  'required',
            'CI_Usuario'        =>  'required',
            'Nombre_Usuario'    =>  'required',
            'FechaNacimiento_Usuario' =>  'required',
            'Cel_Usuario'             =>  'required',
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
