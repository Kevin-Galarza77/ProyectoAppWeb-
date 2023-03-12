<?php

namespace App\Http\Controllers\SubCategories\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SubCategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CreateSubCategoriaController extends Controller
{
    public function store(Request $request)
    {
        $alert = 'No se pudo crear la subcategoria, intenta nuevamente';
        $status = false;
        $data = [];
        $messages = [];

        $validator = $this->validateData($request->all());

        if ($validator['status'] == false) {

            $messages = $validator['messages'];

        } else {

            $subCategoria = new SubCategoria();

            $subCategoria->nombre  =  $request['nombre'];

            $file = request()->file('imagen');
            $obj  = Cloudinary::upload($file->getRealPath(), ['folder' => 'subCategoria']);

            $subCategoria->public_id    =  $obj->getPublicId();
            $subCategoria->url          =  $obj->getSecurePath();
            $subCategoria->categoria_id = $request['categoria_id'];
            $subCategoria->created_at   =  now('America/Guayaquil')->format('Y-m-d H:i:s');
            $subCategoria->updated_at   =  now('America/Guayaquil')->format('Y-m-d H:i:s');
            $subCategoria->save();

            $status = true;
            $alert = 'La SubCategoria se ha registrado con exito';

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
            'nombre.required'         => 'El nombre es requerido.',
            'categoria_id.required'   => 'El id de la categoria es requerida.',
            'imagen.required'         => 'La imagen es requerida.',
            'imagen.image'            => 'La imagen no contiene un archivo compatible.',
            'imagen.mimes'            => 'La imagen no contiene un archivo compatible.'
        ];

        $validate = [
            'nombre'       => 'required',
            'categoria_id' => 'required',
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
