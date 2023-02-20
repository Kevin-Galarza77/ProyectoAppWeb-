<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usuarios extends Model
{
    use HasFactory;
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function rol(){
        return $this->belongsTo(rol::class);
    }

    public function cabecera__pedidos(){
        return $this->hasMany(Cabecera_Pedidos::class);
    }

}

