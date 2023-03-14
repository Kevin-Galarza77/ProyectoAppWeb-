<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle_Pedido extends Model
{
    use HasFactory;

    public function cabezera_pedidos(){
        return $this->belongsTo(Cabecera_Pedidos::class,'cabecera__pedido_id');
    }

    public function productos(){
        return $this->belongsTo(Producto::class,'producto_id');
    }

}
