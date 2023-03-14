<?php


namespace App\Http\Controllers\Categorias\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;

class UpdateCategoriaController extends Controller
{
    public function update(Request $request, $id)
    {

        $alert    = 'No se pudo actualilzar la Categoria, intenta nuevamente';
        $status   = false;
        $messages = [];


        $categoria = Categoria::find($id);

        if ($categoria != null) {
            //dd($request->all());
            $validator = $this->validateData($request->all());

            if ($validator['status'] == false) {

                $messages = $validator['messages'];

            } else {

                $categoria->nombre       =  $request['nombre'];

                if ($request->hasFile('imagen')){
                    Cloudinary::destroy($categoria->public_id);
                    $file = request()->file('imagen');
                    $obj  = Cloudinary::upload($file->getRealPath(), ['folder' => 'categories']);
                    $categoria->public_id  =  $obj->getPublicId();
                    $categoria->url        =  $obj->getSecurePath();
                }

                $categoria->updated_at            =  now('America/Guayaquil')->format('Y-m-d H:i:s');
                $categoria->update();

                $status = true;
                $alert = 'La Categoria se ha actualizado con exito';
            }
        }

        return [
            'alert'     =>  $alert,
            'messages'  =>  $messages,
            'status'    =>  $status,
        ];
    }

    public function validateData($data)
    {
        $status = true;
        $messages = [
            'nombre.required'      => 'El nombre de la categoria es requerido.',
            'imagen.image'         => 'La imagen no contiene un archivo compatible.',
            'imagen.mimes'         => 'La imagen no contiene un archivo compatible.'
        ];

        $validate = [
            'nombre'       => 'required',
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
