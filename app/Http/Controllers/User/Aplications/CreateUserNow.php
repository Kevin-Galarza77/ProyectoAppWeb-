<?php

namespace App\Http\Controllers\Users\Applications;

use App\Http\Controllers\Users\Applications\User;
use Illuminate\Support\Facades\DB;

class CreateUserNow extends User 
{
    public function create()
    {
        dd($this->user);
        $user = new $this->model;
        $user->email         =   $this->user['email'];
        $user->password        =   bcrypt($this->user['password']);

        if($user->save()){            
           $this->userStatus = true;

           $this->user = DB::table('users')->latest('user_id')->first();
           
       }else{
           $this->userStatus = false;
       }
    }

}