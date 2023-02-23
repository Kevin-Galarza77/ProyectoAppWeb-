<?php

namespace App\Http\Controllers\User\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateUserController extends Controller
{

    public function update(Request $request, $id)
    {
        $alert = 'No se pudo actualizar, intenta nuevamente';
        $status = false;
        $data = [];
        $messages = [];

        $validator = $this->validateData($request->all(),$id);

        if ($validator['status'] == false) {

            $messages = $validator['messages'];

        } else {

            $user = User::find($id);

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


    public function validateData($data,$id)
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
