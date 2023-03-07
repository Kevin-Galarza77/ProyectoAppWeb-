<?php

namespace App\Http\Controllers\Productos\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class UpdateProductoController extends Controller
{
    public function update(Request $request, $id)
    {
        $alert = 'No se pudo actualizar, intenta nuevamente';
        $status = false;
        $data = [];
        $messages = [];

        $producto = Producto::find($id);
        $user_id = PersonalAccessToken::findToken($request->bearerToken())->first()->tokenable_id;

        if (!$producto) {
            $messages[] = 'El producto no existe';
        } else if ($producto->user_id !== $user_id) {
            $messages[] = 'No tienes permiso para editar este producto';
        } else {
            
            $validator = $this->validateData($request->all(), $id);

            if ($validator['status'] == false) {

                $messages = $validator['messages'];

            } else {

                $producto->id                       = $request['nombre'];
                $producto->codigo_Producto          = $request['codigo_Producto'];
                $producto->Nombre_Producto          = $request['Nombre_Producto'];
                $producto->Stock_Producto           = $request['Stock_Producto'];
                $producto->Precio_Producto          = $request['Precio_Producto'];
                $producto->public_id                = $request['public_id'];
                $producto->Descripcion_Producto     = $request['Descripcion_Producto'];
                $producto->created_at               = $request['created_at'];
                $producto->updated_at               = $request['updated_at'];
                $producto->update();

                $status = true;
                $alert = 'El producto se ha actualizado con éxito';
            }
        }

        return [
            'alert'     =>  $alert,
            'messages'  =>  $messages,
            'status'    =>  $status,
            'data'      =>  $data
        ];
    }

    public function validateData($data, $id)
    {
        $status = true;
        $messages = [
            'id.required'                   => 'El id del producto es requerido.',
            'id.numeric'                    => 'El id debe ser un numero.',
            'id.unique'                     => 'El id ya se encuentra registrado.',
            'codigo_Producto.required'      => 'El codigo de producto es requerido.',
            'codigo_Producto.unique'        => 'El codigo de producto ya se encuentra registrado.',
            'Nombre_Producto.required'      => 'El nombre del producto es requerido.',
            'Stock_Producto.required'       => 'El stock del producto es requerido.',
            'Stock_Producto.numeric'        => 'El stock debe ser un número.',       
            'Precio_Producto.required'      => 'El precio es requerido.',
            'Precio_Producto.numeric'       => 'El precio debe ser un número.',
            'public_id.required'            => 'El id publico es requerido.',
            'public_id.unique'              => 'El id publico ya se encuentra registrado.',
            'Descripcion_Producto.required' => 'Una descripcion es requerida.',
            'created_at'                    => 'La fecha de creacion del producto es requerida.',
            'updated_at'                    => 'La fecha de actualización del producto es requerida.'
        ];  

        $validate = [
            'id'                    => 'required|numeric|unique',
            'codigo_Producto'       => 'required|unique',
            'Nombre_Producto'       => 'required',
            'Stock_Producto'        => 'required|numeric',
            'Precio_Producto'       => 'required|numeric',
            'public_id'             => 'required|unique',
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
