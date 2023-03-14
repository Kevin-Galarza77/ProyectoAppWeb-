<?php

namespace App\Http\Controllers\Pedidos\Aplication;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Pedidos\Controllers\CreateCabeceraPedidosController;
use App\Models\Cabecera_Pedidos;
use App\Models\usuarios;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\PersonalAccessToken;

class ApiCabeceraPedidosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidos = Cabecera_Pedidos::with('detalles_pedidos.productos','usuario')->get();
        return $pedidos;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCabecera_PedidosRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pedido = new CreateCabeceraPedidosController();
        return $pedido->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cabecera_Pedidos  $cabecera_Pedidos
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {

        $status = false;
        $alert = 'Se ha producido un error al encontrar el pedido';
        $messages = [];
        $data = [];


        switch ($id) {
            case 'ForCabezeraId':
                $validator = Validator::make(
                    $request->all(),
                    [
                        'cabezara_id' => ['required', 'numeric', Rule::exists('cabecera__pedidos', 'id')]
                    ],
                    [
                        'cabezara_id.required' => 'El id de la Cabezera es requerido',
                        'cabezara_id.numeric'  => 'El id de la Cabezera es numerico',
                        'cabezara_id.exists'   => 'El id de la Cabezera no existe'
                    ]
                );
                break;

            case 'ForUserId':
                $validator = Validator::make(
                    $request->all(),
                    [
                        'token' => ['required']
                    ],
                    [
                        'token.required'       => 'El token del usuario es requerido'
                    ]
                );
                break;
        }



        if ($validator->fails()) {
            $messages = $validator->errors()->all();
        } else {
            switch ($id) {
                case 'ForCabezeraId':
                    $pedido = Cabecera_Pedidos::with('detalles_pedidos')->find($request->cabezara_id);
                    if ($pedido != null) {
                        $data = $pedido;
                        $alert = 'Se ha encontrado el pedido';
                        $status = true;
                    }
                    break;

                case 'ForUserId':
                    try {
                        $user_id    = PersonalAccessToken::findToken($request->token)->first()->tokenable_id;
                        $usuario    = usuarios::where('user_id', $user_id)->first();
                        $pedidos     = Cabecera_Pedidos::with('detalles_pedidos.productos','usuario')->where('usuario_id', $usuario->id)->get();
                        if ($pedidos != null) {
                            $data       = $pedidos;
                            $alert      = 'Se han encontrado los pedidos';
                            $status     = true;
                        }
                    } catch (\Throwable $th) {
                        $messages = ['El token no existe'];
                    }
                    break;
            }
        }


        return [
            'alert'     =>  $alert,
            'status'    =>  $status,
            'messages'  =>  $messages,
            'data'      =>  $data
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cabecera_Pedidos  $cabecera_Pedidos
     * @return \Illuminate\Http\Response
     */
    public function edit(Cabecera_Pedidos $cabecera_Pedidos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCabecera_PedidosRequest  $request
     * @param  \App\Models\Cabecera_Pedidos  $cabecera_Pedidos
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {

        $status = false;
        $alert = 'Se ha producido un error al actualizar el pedido';
        $messages = [];

        $validator = Validator::make(
            $request->all(),
            [
                'cabezara_id' => ['required', 'numeric', Rule::exists('cabecera__pedidos', 'id')],
                'estado'      => ['required', 'numeric', Rule::exists('estados__pedidos', 'id')]
            ],
            [
                'cabezara_id.required' => 'El id de la Cabezera es requerido',
                'cabezara_id.numeric'  => 'El id de la Cabezera es numerico',
                'cabezara_id.exists'   => 'El id de la Cabezera no existe',
                'estado.required'      => 'El id del estado es requerido',
                'estado.numeric'       => 'El id del estado es numerico',
                'estado.exists'        => 'El id del estado no existe'
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
        } else {
            switch ($id) {
                case 'updateEstado':
                    $cabezera = Cabecera_Pedidos::find($request->cabezara_id);
                    $cabezera->estados__pedido_id  = $request->estado;
                    $cabezera->update();

                    $alert = 'Se ha actualizado el estado del pedido exitosamente';
                    $status = true;
                    break;

                default:
                    # code...
                    break;
            }
        }

        return [
            'alert'     =>  $alert,
            'status'    =>  $status,
            'messages'  =>  $messages
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cabecera_Pedidos  $cabecera_Pedidos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cabecera_Pedidos $cabecera_Pedidos)
    {
        //
    }
}
