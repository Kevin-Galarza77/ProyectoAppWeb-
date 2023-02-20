<?php

namespace App\Http\Controllers\Drivers\Applications;
use App\Util\YobelORM;


Abstract Class Usuario extends YobelORM
{
    public $usuario = null;
    public $usuarios = [];
    public $usuarioStatus = false;
    public $model;

    public function __construct($data = [])
    {
        
        $this->usuario = $data;
        $this->model = "App\Models\usuarios";
    }

    public function initConsult($select = ['*'])
    {
        $this->sql = $this->model::select($select);
    }   

}