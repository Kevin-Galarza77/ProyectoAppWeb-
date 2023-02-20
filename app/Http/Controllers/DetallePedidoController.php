<?php

namespace App\Http\Controllers;

use App\Models\Detalle_Pedido;
use App\Http\Requests\StoreDetalle_PedidoRequest;
use App\Http\Requests\UpdateDetalle_PedidoRequest;

class DetallePedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreDetalle_PedidoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDetalle_PedidoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Detalle_Pedido  $detalle_Pedido
     * @return \Illuminate\Http\Response
     */
    public function show(Detalle_Pedido $detalle_Pedido)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Detalle_Pedido  $detalle_Pedido
     * @return \Illuminate\Http\Response
     */
    public function edit(Detalle_Pedido $detalle_Pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDetalle_PedidoRequest  $request
     * @param  \App\Models\Detalle_Pedido  $detalle_Pedido
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDetalle_PedidoRequest $request, Detalle_Pedido $detalle_Pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Detalle_Pedido  $detalle_Pedido
     * @return \Illuminate\Http\Response
     */
    public function destroy(Detalle_Pedido $detalle_Pedido)
    {
        //
    }
}
