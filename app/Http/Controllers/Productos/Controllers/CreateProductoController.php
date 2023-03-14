<?php

namespace App\Http\Controllers\Productos\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CreateProductoController extends Controller
{
    public function store(Request $request)
    {
        $alert = 'No se pudo crear el producto, intenta nuevamente';
        $status = false;
        $data = [];
        $messages = [];

        $validator = $this->validateData($request->all());

        if ($validator['status'] == false) {

            $messages = $validator['messages'];
        } else {

            $producto = new Producto();

            $producto->codigo_Producto       =  $request['codigo_Producto'];
            $producto->Nombre_Producto       =  $request['Nombre_Producto'];
            $producto->Stock_Producto        =  $request['Stock_Producto'];
            $producto->Precio_Producto       =  $request['Precio_Producto'];

            $file = request()->file('imagen');
            $obj  = Cloudinary::upload($file->getRealPath(), ['folder' => 'products']);

            $producto->public_id             =  $obj->getPublicId();
            $producto->url                   =  $obj->getSecurePath();
            $producto->Descripcion_Producto  =  $request['Descripcion_Producto'];
            $producto->subCategoria_id       =  $request['subCategoria_id'];
            $producto->created_at            =  now('America/Guayaquil')->format('Y-m-d H:i:s');
            $producto->updated_at            =  now('America/Guayaquil')->format('Y-m-d H:i:s');
            $producto->save();

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
            'codigo_Producto.required'      => 'El codigo de producto es requerido.',
            'Nombre_Producto.required'      => 'El nombre del producto es requerido.',
            'Stock_Producto.required'       => 'El stock del producto es requerido.',
            'Stock_Producto.numeric'        => 'El stock debe ser un número.',
            'Precio_Producto.required'      => 'El precio es requerido.',
            'Precio_Producto.numeric'       => 'El precio debe ser un número.',
            'Descripcion_Producto.required' => 'La descripcion es requerida.',
            'subCa tegoria_id.required'      => 'La Sub Categoria es requerida.',
            'subCategoria_id.numeric'       => 'La Sub Categoria debe ser numerica.',
            'imagen.required'               => 'La imagen es requerida.',
            'imagen.image'                  => 'La imagen no contiene un archivo compatible.',
            'imagen.mimes'                  => 'La imagen no contiene un archivo compatible.'
        ];

        $validate = [
            'codigo_Producto'       => 'required',
            'Nombre_Producto'       => 'required',
            'Stock_Producto'        => 'required|numeric',
            'Precio_Producto'       => 'required|numeric',
            'Descripcion_Producto'  => 'required',
            'subCategoria_id'       => 'required|numeric',
            'imagen'                => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
