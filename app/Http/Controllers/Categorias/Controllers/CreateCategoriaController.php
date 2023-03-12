<?php

namespace App\Http\Controllers\Categorias\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CreateCategoriaController extends Controller
{
    public function store(Request $request)
    {
        $alert = 'No se pudo crear la Categoria, intenta nuevamente';
        $status = false;
        $data = [];
        $messages = [];

        $validator = $this->validateData($request->all());

        if ($validator['status'] == false) {

            $messages = $validator['messages'];
        } else {

            $categoria = new Categoria();

            $categoria->nombre  =  $request['nombre'];

            $file = request()->file('imagen');
            $obj  = Cloudinary::upload($file->getRealPath(), ['folder' => 'catagories']);

            $categoria->public_id             =  $obj->getPublicId();
            $categoria->url                   =  $obj->getSecurePath();
            $categoria->created_at            =  now('America/Guayaquil')->format('Y-m-d H:i:s');
            $categoria->updated_at            =  now('America/Guayaquil')->format('Y-m-d H:i:s');
            $categoria->save();

            $status = true;
            $alert = 'La Categoria se ha registrado con exito';

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
            'nombre.required'      => 'El nombre es requerido.',
            'imagen.required'      => 'La imagen es requerida.',
            'imagen.image'         => 'La imagen no contiene un archivo compatible.',
            'imagen.mimes'         => 'La imagen no contiene un archivo compatible.'
        ];

        $validate = [
            'nombre'       => 'required',
            'imagen'       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
