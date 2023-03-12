<?php

namespace App\Http\Controllers\SubCategories\Aplication;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SubCategories\Controllers\UpdateSubCategoriaController;
use App\Http\Controllers\SubCategories\Controllers\CreateSubCategoriaController;
use App\Models\SubCategoria;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ApiSubCategoriaController extends Controller
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
        $subCategoria = SubCategoria::all();

        if ($subCategoria != null) {
            $status = true;
            $alert  = 'Se han encontrado las categorias';
            $data   = $subCategoria;
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
     * @param  \App\Http\Requests\StoreSubCategoriaRequest  $request
     * @return array
     */
    public function store(Request $request)
    {
        $subCategoria = new CreateSubCategoriaController();
        return $subCategoria->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubCategoria  $subCategoria
     * @return \Illuminate\Http\Response
     */
    public function show($typeSearch, Request $request)
    {

        $data = [];
        $status = false;
        $alert = 'Se ha producido un error al extraer las subcategoria(s)';
        $messages = [];

        switch ($typeSearch) {

            case 'ForCategory':
                $validator = Validator::make(
                    $request->all(),
                    ['categoria_id' => 'required'],
                    ['categoria_id.required' => 'La categoria es requerido']
                );
                break;
            case 'Subcategory':
                $validator = Validator::make(
                    $request->all(),
                    ['subcategoria_id' => 'required'],
                    ['subcategoria_id.required' => 'La SubCategoria es requerido']
                );
            default:
                # code...
                break;
        }


        if ($validator->fails()) {

            $messages = $validator->errors()->all();

        } else {
            switch ($typeSearch) {

                case 'ForCategory':
                    $subcategorias = SubCategoria::where('categoria_id', $request->categoria_id)->get();
                    $alert  = 'Se encontraron las subcategorias';
                    $status = true;
                    $data   = $subcategorias;
                    break;
                case 'Subcategory':
                    $subcategorias = SubCategoria::find($request->subcategoria_id);
                    $alert  = 'Se encontro la subcategoria';
                    $status = true;
                    $data   = $subcategorias;
                default:
                    # code...
                    break;
            }
        }

        return [
            'alert'     =>  $alert,
            'status'    =>  $status,
            'data'      =>  $data,
            'messages'  =>  $messages
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubCategoria  $subCategoria
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategoria $subCategoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubCategoriaRequest  $request
     * @param  \App\Models\SubCategoria  $subCategoria
     * @return array
     */
    public function update(Request $request, $id)
    {
        $subCategoria = new UpdateSubCategoriaController();
        return $subCategoria->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\SubCategoria $subCategoria
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status     = false;
        $alert      = 'Se ha producido un error al eliminar la SubCategoria';
        $messages   = ['No se ha encontrado la SubCategoria'];


        $subCategoria = subcategoria::find($id);
        if ($subCategoria!== null) {
            $subCategoria->delete();
            $status     = true;
            $alert      = 'Se ha eliminado la SubCategoria';
            $messages   = [];
        }

        return [
            'alert'     =>  $alert,
            'status'    =>  $status,
            'messages'  =>  $messages
        ];

    }
}
