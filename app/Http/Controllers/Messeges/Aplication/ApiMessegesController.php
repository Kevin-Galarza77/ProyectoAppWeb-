<?php

namespace App\Http\Controllers\Messeges\Aplication;

use App\Http\Controllers\Controller;
use App\Models\Messeges;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateMessegesRequest;
use Illuminate\Support\Facades\Validator;

class ApiMessegesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messeges = Messeges::with('usuario')->get();
        return $messeges;
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
     * @param  \App\Http\Requests\StoreMessegesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mensaje' => 'required','usuario_id' => 'required|numeric'
        ], [
            'mensaje.required'      => 'El mensaje es requerida',
            'usuario_id.required'   => 'El id del usuario requerida',
            'usuario_id.numeric'    => 'El id del usuario es numerico'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $status = false;
            return [
                'alert'     =>  'No se pudo enviar el mensaje',
                'messages'   =>  $messages,
                'status'     =>  $status
            ];
        } else{
            $mensaje = new Messeges();
            $mensaje->message     = $request->mensaje;
            $mensaje->usuario_id  = $request->usuario_id ;
            $mensaje->save();
            return [
                'alert'     =>  'El mensaje a sido enviado.',
                'status'     =>  true
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Messeges  $messeges
     * @return \Illuminate\Http\Response
     */
    public function show(Messeges $messeges)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Messeges  $messeges
     * @return \Illuminate\Http\Response
     */
    public function edit(Messeges $messeges)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMessegesRequest  $request
     * @param  \App\Models\Messeges  $messeges
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMessegesRequest $request, Messeges $messeges)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Messeges  $messeges
     * @return \Illuminate\Http\Response
     */
    public function destroy(Messeges $messeges)
    {
        //
    }
}
