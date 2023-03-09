<?php

namespace App\Http\Controllers\SubCategories\Controlers;

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

        $subcategoria = Subcategoria::find($id);

        if ($subcategoria != null) {
            $validator = $this->validateData($request->all());

            if ($validator['status'] == false) {
                $messages = $validator['messages'];
            } else {
                $subcategoria->id  = $request['id '];
                $subcategoria->nombre = $request['nombre'];
                $subcategoria->url = $request['url'];
                $subcategoria->categoria_id  = $request['categoria_id '];
                $subcategoria->updated_at = now('America/Guayaquil')->format('Y-m-d H:i:s');

                if ($request->hasFile('imagen')) {
                    Cloudinary::destroy($subcategoria->public_id);
                    $file = $request->file('imagen');
                    $obj = Cloudinary::upload($file->getRealPath(), ['folder' => 'products']);
                    $subcategoria->public_id = $obj->getPublicId();
                    $subcategoria->url = $obj->getSecurePath();
                }

                $subcategoria->update();

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
            'id.required'     => 'El id es requerido.',
            'nombre.required' => 'El nombre del producto es requerido.',
            'imagen.required' => 'La imagen es requerida.',
            'imagen.image'    => 'La imagen no contiene un archivo compatible.',
            'imagen.mimes'    => 'La imagen no contiene un archivo compatible.'
        ];

        $validate = [
            'id '    => 'required',
            'nombre' => 'required',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}