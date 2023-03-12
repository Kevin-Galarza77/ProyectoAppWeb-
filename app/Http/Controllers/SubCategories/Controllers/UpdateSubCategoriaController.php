<?php

namespace App\Http\Controllers\SubCategories\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subcategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


class UpdateSubCategoriaController extends Controller
{
    public function update(Request $request, $id)
    {
        $alert = 'No se pudo actualizar la subcategoria, inténtalo de nuevo.';
        $status = false;
        $messages = [];

        $subCategoria = SubCategoria::find($id);

        if ($subCategoria != null) {
            $validator = $this->validateData($request->all());

            if ($validator['status'] == false) {
                $messages = $validator['messages'];
            } else {
                $subCategoria->id  = $request['id'];
                $subCategoria->nombre = $request['nombre'];
                $subCategoria->url = $request['url'];
                $subCategoria->categoria_id  = $request['categoria_id'];
                $subCategoria->updated_at = now('America/Guayaquil')->format('Y-m-d H:i:s');

                if ($request->hasFile('imagen')) {
                    Cloudinary::destroy($subCategoria->public_id);
                    $file = $request->file('imagen');
                    $obj = Cloudinary::upload($file->getRealPath(), ['folder' => 'subCategoria']);
                    $subCategoria->public_id = $obj->getPublicId();
                    $subCategoria->url = $obj->getSecurePath();
                }

                $subCategoria->update();

                $status = true;
                $alert = 'La subcategoria se ha actualizado con éxito.';
            }
        }

        return [
            'alert' => $alert,
            'messages' => $messages,
            'status' => $status,
        ];
    }

    public function validateData($data)
    {
        $status = true;
        $messages = [
            'nombre.required'       => 'El nombre del producto es requerido.',
            'categoria_id.required' => 'La Categoria es requerida',
            'categoria_id.numeric'  => 'La Categoria debe ser un numero',
            'imagen.image'          => 'La imagen no contiene un archivo compatible.',
            'imagen.mimes'          => 'La imagen no contiene un archivo compatible.'
        ];

        $validate = [
            'nombre'       => 'required',
            'categoria_id' => 'required|numeric',
            'imagen'       => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
