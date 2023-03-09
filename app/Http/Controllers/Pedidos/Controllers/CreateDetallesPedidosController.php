<?php

namespace App\Http\Controllers\Pedidos\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Detalle_Pedido;
use App\Models\Producto;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class CreateDetallesPedidosController extends Controller
{



    public function store($pedido_id, $detalles)
    {

        $status = false;
        $messages = [];
        $validateDatos = true;

        foreach ($detalles as $detalle) {
            $validator = $this->validateData($detalle);
            if (!$validator['status']) {
                $messages      = $validator['messages'];
                $validateDatos = false;
                break;
            }
        }

        if ($validateDatos) {

            $validateStock = $this->validateStocks($detalles);

            if (!$validateStock['status']) {

                foreach ($validateStock['messages'] as $sms) {
                    array_push($messages, $sms);
                }
                
            } else {
                
                $status=true;

                foreach ($detalles as $detalle) {
                    $newDetalle = new Detalle_Pedido();
                    $newDetalle['Cantidad_Productos']  = $detalle['Cantidad_Productos'];
                    $newDetalle['Subtotal_Productos']  = $detalle['Subtotal_Productos'];
                    $newDetalle['producto_id']         = $detalle['producto_id'];
                    $newDetalle['cabecera__pedido_id'] = $pedido_id;
                    $newDetalle['created_at']          = now('America/Guayaquil')->format('Y-m-d H:i:s');
                    $newDetalle->save();

                    $detalleStock                    = Producto::find($detalle['producto_id']);
                    $detalleStock['Stock_Producto']  = $detalleStock['Stock_Producto'] - $detalle['Cantidad_Productos'];
                    $detalleStock->save();
                }
            }
        }

        return [
            'messages'  =>  $messages,
            'status'    =>  $status
        ];
    }

    public function validateStocks($detalles)
    {
        $status = true;
        $messages = [];



        foreach ($detalles as $detalle) {

            $detalleStock = Producto::find($detalle['producto_id']);

            if ($detalle['Cantidad_Productos'] > $detalleStock['Stock_Producto']) {
                array_push($messages, 'El producto ' . $detalleStock['Nombre_Producto'] . ' tiene solamente ' . $detalleStock['Stock_Producto'] . ' de stock');
                $status = false;
            }
        }

        return [
            'messages'  =>  $messages,
            'status'    =>  $status
        ];
    }
    public function validateData($data)
    {
        $status = true;
        $messages = [
            'Cantidad_Productos.required'       =>  'La cantidad del producto es requerido',
            'Cantidad_Productos.numeric'        =>  'La cantidad del producto es numerico',
            'Subtotal_Productos.required'       =>  'El subtotal del producto es requerido',
            'Subtotal_Productos.numeric'        =>  'El subtotal del producto es numerico',
            'producto_id.required'              =>  'El Producto es requerido',
            'producto_id.numeric'               =>  'El Producto es numerico',
            'producto_id.exists'                =>  'Alguno de los productos no existen'
        ];

        $validate = [
            'Cantidad_Productos'      =>  'required|numeric',
            'Subtotal_Productos'      =>  'required|numeric',
            'producto_id'             => ['required', 'numeric', Rule::exists('productos', 'id')]
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
