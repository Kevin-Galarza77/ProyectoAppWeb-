<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estados_Pedidos extends Model
{
    use HasFactory;

    public function cabecera__pedidos(){
        return $this->belongsTo(User::class);
    }
}
