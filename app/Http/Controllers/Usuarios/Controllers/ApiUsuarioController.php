<?php

namespace App\Http\Controllers\Usuarios\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = usuarios::with('user')->get();
        return $usuarios;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'opcion' => 'required|boolean'
        ], [
            'opcion.required' => 'La opción para crear el usuario es requerida',
            'opcion.boolean' => 'La opción para crear el usuario debe ser verdadero o falso'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $status = false;
            return [
                'messages'   =>  $messages,
                'status'     =>  $status
            ];
        } else {
            if ($request['opcion']) {
                $usuario = new CreatUsuarioController();
                return $usuario->store($request);
            } else {
                $usuario = new CreatUserByAdminController();
                return $usuario->store($request);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $status  = false;
        $alert   = 'No se a encontrado el usuario.';
        $data    = [];
        try {
            $user    = usuarios::with('user')->where('user_id', $user_id)->first();
            if ($user != null) {
                $status = true;
                $alert  = 'Usuario encontrado';
                $data   = $user;
            }
        } catch (\Throwable $th) {
            $th;
        }

        return [
            'status' => $status,
            'alert' => $alert,
            'data'  => $data
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {

        $validator = Validator::make($request->all(), [
            'opcion' => 'required|boolean'
        ], [
            'opcion.required' => 'La opción para actualizar el usuario es requerida',
            'opcion.boolean' => 'La opción para actualizar el usuario debe ser verdadero o falso'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $status = false;
            return [
                'messages'   =>  $messages,
                'status'     =>  $status
            ];
        } else{
            if ($request['opcion']){
                $user = new UpdateUserByAdminController();
                return $user->update($request, $user_id);
            }else{
                $user = new UpdateUsuarioController();
                return $user->update($request, $user_id);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
