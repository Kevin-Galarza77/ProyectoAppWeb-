<?php

namespace App\Http\Controllers\Usuarios\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\usuarios;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

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
        $usuario = new CreatUsuarioController();

        return $usuario->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($token)
    {
        $status  = false;
        $alert   = 'No se a encontrado el usuario.';
        $data    = [];
        try {
            $id      = PersonalAccessToken::findToken($token)->first()->tokenable_id;
            $user    = usuarios::with('user')->where('user_id', $id)->first();
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
    public function update(Request $request, $token)
    {
        $user = new UpdateUsuarioController();
        return $user->update($request, $token);
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
