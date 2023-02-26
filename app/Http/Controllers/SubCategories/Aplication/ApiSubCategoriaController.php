<?php

namespace App\Http\Controllers\SubCategories\Aplication;

use App\Http\Controllers\Controller;
use App\Models\SubCategoria;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreSubCategoriaRequest;
use App\Http\Requests\UpdateSubCategoriaRequest;
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
        return SubCategoria::all();
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
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubCategoriaRequest $request)
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubCategoriaRequest $request, SubCategoria $subCategoria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategoria  $subCategoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategoria $subCategoria)
    {
        //
    }
}
