<?php

namespace App\Http\Controllers\Productos\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeleteProductoController extends Controller
{
   
    public function destroy(Producto $producto)
    {
        try {
            $producto->delete();
            
            return response()->json([
                'message' => 'El producto ha sido eliminado con éxito.'
            ]);
        } catch (\Exception $e) {
            
            return response()->json([
                'message' => 'Ocurrió un error al eliminar el producto.'
            ], 500);
        }
    }
}