<?php
namespace App\Http\Controllers\Productos\Controller;

use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            $producto = new Producto;
            $producto->id                       = $request['id'];
            $producto->codigo_Producto          = $request['codigo_Producto'];
            $producto->Nombre_Producto          = $request['Nombre_Producto'];
            $producto->Stock_Producto           = $request['Stock_Producto'];
            $producto->Precio_Producto          = $request['Precio_Producto'];
            $producto->public_id                = $request['public_id'];
            $producto->Descripcion_Producto     = $request['Descripcion_Producto'];
            $producto->subCategoria_id          = $subCategoria->id;
            $producto->created_at               = $request['created_at'];
            $producto->updated_at               = $request['updated_at'];
            $producto->save();

            $status=true;
            $alert='El preoducto se ha registrado con exito';
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
            'id.required'                   => 'El id del producto es requerido.',
            'id.numeric'                    => 'El id debe ser un numero.',
            'codigo_Producto.required'      => 'El codigo de producto es requerido.',
            'Nombre_Producto.required'      => 'El nombre del producto es requerido.',
            'Stock_Producto.required'       => 'El stock del producto es requerido.',
            'Stock_Producto.numeric'        => 'El stock debe ser un número.',       
            'Precio_Producto.required'      => 'El precio es requerido.',
            'Precio_Producto.numeric'       => 'El precio debe ser un número.',
            'public_id.required'            => 'El id publico es requerido.',
            'Descripcion_Producto.required' => 'Una descripcion es requerida.',
            'created_at'                    => 'La fecha de creacion del producto es requerida.',
            'updated_at'                    => 'La fecha de actualización del producto es requerida.'
        ];  

        $validate = [
            'id'                    => 'required|numeric',
            'codigo_Producto'       => 'required',
            'Nombre_Producto'       => 'required',
            'Stock_Producto'        => 'required|numeric',
            'Precio_Producto'       => 'required|numeric',
            'public_id'             => 'required',
            'Descripcion_Producto'  => 'required',
            'created_at'            => 'required',
            'updated_at'            => 'required'
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