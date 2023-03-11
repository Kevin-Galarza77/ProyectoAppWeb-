<?php

namespace App\Http\Controllers\Pedidos\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cabecera_Pedidos;
use App\Models\User;
use App\Models\usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class CreateCabeceraPedidosController extends Controller
{

    public function store(Request $request)
    {

        $alert = 'No se pudo crear el pedido, intenta nuevamente';
        $status = false;
        $data = [];
        $messages = [];

        $validator = $this->validateData($request->all());

        if ($validator['status'] == false) {

            $messages = $validator['messages'];
        } else {

            $cabezera = new Cabecera_Pedidos();
            $user_id    = PersonalAccessToken::findToken($request->token)->first()->tokenable_id;
            $usuario    = usuarios::where('user_id', $user_id)->first();

            $cabezera->Tipo_Pago_NotaVenta       = $request->Tipo_Pago_NotaVenta;
            $cabezera->Total_Pago_NotaVenta      = $request->Total_Pago_NotaVenta;
            $cabezera->Fecha_NotaVenta           = now('America/Guayaquil')->format('Y-m-d H:i:s');
            $cabezera->Direccion_NotaVenta       = $request->Direccion_NotaVenta;
            $cabezera->usuario_id                = $usuario->id;
            $cabezera->estados__pedido_id        = $request->estados__pedido_id;
            $cabezera->tipo_entrega__pedido_id   = $request->tipo_entrega__pedido_id;
            $cabezera->created_at                = now('America/Guayaquil')->format('Y-m-d H:i:s');
            $cabezera->estados__pedido_id        = 1;
            $cabezera->save();

            $Createdetalles = new CreateDetallesPedidosController();
    
            $detalles = $Createdetalles->store($cabezera->id,$request->detalles);

            if (!$detalles['status']) {
                $cabezera->delete();
                $messages = $detalles['messages'];
            }else{
                $alert= 'Se ha creado el pedido exitosamente';
                $status = true;
            }

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
            'Tipo_Pago_NotaVenta.required'      =>  'El Tipo de pago de la Nota de Venta es requerido',
            'Tipo_Pago_NotaVenta.in'            =>  'El Tipo de pago de la Nota de Venta solo puede ser Credito o Efectivo',
            'Total_Pago_NotaVenta.required'     =>  'El total de la Nota de Venta es requerida',
            'Total_Pago_NotaVenta.numeric'      =>  'El total de la Nota de Venta debe ser un dato numerico',
            'Direccion_NotaVenta.required'      =>  'La Direccion de la Nota de Venta es requerida',
            'token.required'                    =>  'El token del usuario es requerido',
            'tipo_entrega__pedido_id.required'  =>  'El Tipo de Entraga de la Nota de Venta es requerido',
            'tipo_entrega__pedido_id.numeric'   =>  'El Tipo de Entraga de la Nota de Venta es numerico',
            'detalles.required'                 =>  'Los Detalles de la Nota de Venta son requeridos',
            'detalles.array'                    =>  'Los Detalles de la Nota de Venta deben ser un array con minimo un registro',
            'detalles.min'                      =>  'Los Detalles de la Nota de Venta deben ser un array con minimo un registro'
        ];

        $validate = [
            'Tipo_Pago_NotaVenta'      =>  'required|in:Credito,Efectivo',
            'Total_Pago_NotaVenta'     =>  'required|numeric',
            'Direccion_NotaVenta'      =>  'required',
            'token'                    =>  'required',
            'tipo_entrega__pedido_id'  =>  'required|numeric',
            'detalles'                 =>  'required|array|min:1',
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
