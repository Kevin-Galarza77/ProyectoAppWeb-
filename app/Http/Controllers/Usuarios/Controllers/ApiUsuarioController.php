<?php

namespace App\Http\Controllers\Usuarios\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\usuarios;
use Illuminate\Http\Request;

class ApiUsuarioController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usuario = new CreatUsuarioController();
        
        return $usuario->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $status  = false;
        $alert   = 'No se a encontrado el usuario.';
        $data    = [];

        $user = usuarios::with('user')->where('id',$id)->first();
        if ($user!=null) {
            $status =true;
            $alert  = 'Usuario encontrado';
            $data   = $user;
        }

        return [
            'status'=> $status,
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
    public function update(Request $request,$id)
    {
        $user = new UpdateUsuarioController();
        return $user->update($request,$id);
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
