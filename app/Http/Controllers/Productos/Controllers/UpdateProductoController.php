<?php


namespace App\Http\Controllers\Productos\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;

class UpdateProductoController extends Controller
{
    public function update(Request $request, $id)
    {
        Log::info('Information message: ' . $request->all());
        $alert    = 'No se pudo actualilzar el producto, intenta nuevamente';
        $status   = false;
        $messages = [];

        // Obtener los datos enviados
        $codProd = $request->input('codigo_Producto');

        $producto = Producto::find($id);

        if ($producto != null) {
            //dd($request->all());
            $validator = $this->validateData($request->all());

            if ($validator['status'] == false) {

                $messages = $validator['messages'];
            } else {

                //$producto = Producto::find($id);

                $producto->codigo_Producto       =  $request->input('codigo_Producto');
                $producto->Nombre_Producto       =  $request['Nombre_Producto'];
                $producto->Stock_Producto        =  $request['Stock_Producto'];
                $producto->Precio_Producto       =  $request['Precio_Producto'];

                if ($request->hasFile('imagen')){
                    Cloudinary::destroy($producto->public_id);
                    $file = request()->file('imagen');
                    $obj  = Cloudinary::upload($file->getRealPath(), ['folder' => 'products']);
                    $producto->public_id  =  $obj->getPublicId();
                    $producto->url        =  $obj->getSecurePath();
                }

                $producto->Descripcion_Producto  =  $request['Descripcion_Producto'];
                $producto->subCategoria_id       =  $request['subCategoria_id'];
                $producto->updated_at            =  now('America/Guayaquil')->format('Y-m-d H:i:s');
                $producto->update();

                $status = true;
                $alert = 'El producto se ha registrado con exito';
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
            'codigo_Producto.required'      => 'El codigo de producto es requerido.',
            'Nombre_Producto.required'      => 'El nombre del producto es requerido.',
            'Stock_Producto.required'       => 'El stock del producto es requerido.',
            'Stock_Producto.numeric'        => 'El stock debe ser un número.',
            'Precio_Producto.required'      => 'El precio es requerido.',
            'Precio_Producto.numeric'       => 'El precio debe ser un número.',
            'Descripcion_Producto.required' => 'La descripcion es requerida.',
            'subCategoria_id.required'      => 'La Sub Categoria es requerida.',
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
