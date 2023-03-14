<?php

namespace App\Http\Controllers\Categorias\Aplication;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Categorias\Controllers\CreateCategoriaController;
use App\Http\Controllers\Categorias\Controllers\UpdateCategoriaController;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ApiCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status     = false;
        $alert      = 'No se han encontrado las categorias';
        $data       = [];
        $categorias = Categoria::all();

        if ($categorias != null) {
            $status = true;
            $alert  = 'Se han encontrado las categorias';
            $data   = $categorias;
        }

        return [
            'alert'     =>  $alert,
            'status'    =>  $status,
            'data'      =>  $data
        ];
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
     * @param  \App\Http\Requests\StoreCategoriaRequest  $request
     * @return array
     */
    public function store(Request $request)
    {
        $categoria = new CreateCategoriaController();
        return $categoria->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoria = Categoria::find($id);
        return $categoria;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit(Categoria $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoriaRequest  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $categoria = new UpdateCategoriaController();
        return $categoria->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Categoria $categoria
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status     = false;
        $alert      = 'Se ha producido un error al eliminar la Categoria';
        $messages   = ['No se ha encontrado la Categoria'];


        $categoria = Categoria::find($id);
        if ($categoria!== null) {
            Cloudinary::destroy($categoria->public_id);
            $categoria->delete();
            $status     = true;
            $alert      = 'Se ha eliminado la Categoria';
            $messages   = [];
        }

        return [
            'alert'     =>  $alert,
            'status'    =>  $status,
            'messages'  =>  $messages
        ];
    }
}
