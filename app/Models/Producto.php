<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    public function subcategoria() {
        return $this->belongsTo('App\Models\SubCategoria','subCategoria_id');
    }
    public function detalles_pedidos(){
        return $this->hasMany(Detalle_Pedido::class,'producto_id');
    }

}
