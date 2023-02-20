<?php

namespace App\Http\Controllers\Users\Applications;
use App\Util\YobelORM;


Abstract Class User extends YobelORM
{
    public $user = null;
    public $users = [];
    public $userStatus = false;
    public $model;

    public function __construct($data = [])
    {
        dd('$data');
        $this->user = $data;
        $this->model = "App\Models\User";
    }

    public function initConsult($select = ['*'])
    {
        $this->sql = $this->model::select($select);
    }   

}