<?php

namespace App\Http\Controllers;

use App\Models\SubCategoria;
use App\Http\Requests\StoreSubCategoriaRequest;
use App\Http\Requests\UpdateSubCategoriaRequest;

class SubCategoriaController extends Controller
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
    public function show(SubCategoria $subCategoria)
    {
        //
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
