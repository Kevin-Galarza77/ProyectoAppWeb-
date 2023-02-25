<?php

namespace App\Http\Controllers\Productos\Aplication;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;

class ApiProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
     * @param  \App\Http\Requests\StoreProductoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {

        $data = [];
        $status = false;
        $alert = 'Se ha producido un error al extraer los prodcto(s)';
        $messages = [];

        switch ($id) {
            case 'favorites':
                $validator = Validator::make(
                    $request->all(),
                    ['token' => 'required'],
                    ['token.required' => 'El token es requerido']
                );
                break;

            case 'ForSubCategory':
                $validator = Validator::make(
                    $request->all(),
                    ['subcategory_id' => 'required'],
                    ['subcategory_id.required' => 'La subcategory del producto es requerido']
                );
                break;
            
            default:
                # code...
                break;
        }


        if ($validator->fails()) {
            $messages = $validator->errors()->all();
        } else {

            // dd($user -> id);
            switch ($id) {
                case 'favorites':

                    $user_id    = PersonalAccessToken::findToken($request->token)->first()->tokenable_id;
                    $user       = User::find($user_id);
                    
                    $resultados = DB::table('cabecera__pedidos as CP')
                        ->join('detalle__pedidos as DP', 'CP.ID', '=', 'DP.cabecera__pedido_id')
                        ->join('productos as PRO', 'PRO.id', '=', 'DP.producto_id')
                        ->select('DP.producto_id', 'PRO.Nombre_Producto', 'PRO.Precio_Producto', 'PRO.Stock_Producto', 'PRO.url', 'PRO.Descripcion_Producto', DB::raw('COUNT(*) as FRECUENCIA_COMPRA'))
                        ->where('usuario_id', '=', $user->id)
                        ->groupBy('CP.ID', 'DP.producto_id', 'PRO.Nombre_Producto', 'PRO.Precio_Producto', 'PRO.Stock_Producto', 'PRO.url', 'PRO.Descripcion_Producto')
                        ->orderBy('FRECUENCIA_COMPRA', 'DESC')
                        ->limit(4)
                        ->get();

                    if (count($resultados) < 4) {
                        $resultados = DB::table('productos')
                            ->orderByRaw('RAND()')
                            ->limit(4)
                            ->get();
                        $data   = $resultados;
                    } else {
                        $data   = $resultados;
                    }

                    $status = true;
                    $alert  = 'Se han encontrado los productos';
                    break;

                case 'ForSubCategory':
                    $resultados = Producto::where('subCategoria_id',$request->subcategory_id)->get();
                    $data = $resultados;
                    $status = true;
                    $alert  = 'Se han encontrado los productos';
                    break;
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
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductoRequest  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
