<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabecera_Pedidos extends Model
{
    use HasFactory;

    public function usuario(){
        return $this->belongsTo(usuarios::class);
    }

    public function estados__pedidos(){
        return $this->hasOne(Estados_Pedidos::class);
    }

    public function tipo_entrega__pedidos(){
        return $this->hasOne(TipoEntrega_Pedidos::class);
    }

    public function detalles_pedidos(){
        return $this->hasMany(Detalle_Pedido::class,'cabecera__pedido_id');
    }
    
}
