<?php

namespace App\Http\Controllers\SubCategories\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SubCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CreateSubCategoriesController extends Controller
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

            $subcategories = new Subcategories();

            $subcategories->id       =  $request['id'];
            $subcategories->nombre   =  $request['nombre'];

            $file = request()->file('imagen');
            $obj  = Cloudinary::upload($file->getRealPath(), ['folder' => 'products']);

            $subcategories->url         =  $obj->getSecurePath();
            $subcategories->categoria_id = $request['Categoria_id'];
            $subcategories->created_at  =  now('America/Guayaquil')->format('Y-m-d H:i:s');
            $subcategories->updated_at  =  now('America/Guayaquil')->format('Y-m-d H:i:s');
            $subcategories->save();

            $status = true;
            $alert = 'El producto se ha registrado con exito';

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
            'id.required'        => 'El id es requerido.',
            'nombre.required'    => 'El nombre es requerido.',
            'imagen.required'    => 'La imagen es requerida.',
            'imagen.image'       => 'La imagen no contiene un archivo compatible.',
            'imagen.mimes'       => 'La imagen no contiene un archivo compatible.'
        ];

        $validate = [
            'id'       => 'required',
            'nombre'   => 'required',
            'categoria_id' => 'required',
            'imagen'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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