<?php

namespace App\Util;


Abstract Class YobelORM
{
    public $sql;

    public function getByPaginate($limit = 0)
    {
        if($limit==0)
        return $this->sql->paginate( config('app.pagination', 20));
        else
        return $this->sql->paginate($limit);
    }

    public function endConsult($type = 1, $limit = 0, $get = null)
    {
        if($limit > 0)
            $this->sql->limit($limit);
        if($type == 1)
            return $this->sql->first();
        else {
            if($type == 3)
            return $this->getByPaginate();
            else
            return $this->sql->get($get);
        }
    }
}