<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoria extends Model
{
    use HasFactory;


    public function productos() {
        return $this->hasMany('App\Models\Producto','subCategoria_id');
    }
    

}
