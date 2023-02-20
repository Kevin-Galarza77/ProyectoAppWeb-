<?php

namespace App\Http\Controllers\Drivers\Applications;
 


class CreateUsuarioCliente extends Usuario
{
    public function create($user){
        
        $usuario = new $this->model;
        $usuario->CI_Usuario = $this->usuario['CI_Usuario'];
        $usuario->Nombre_Usuario = $this->usuario['Nombre_Usuario'];
        $usuario->FechaNacimiento_Usuario = $this->usuario['FechaNacimiento_Usuario'];
        $usuario->Direccion_Usuario = $this->usuario['Direccion_Usuario'];
        $usuario->user_id  = $user;

        try{


        }catch(\Exception $e){
            return 'Mensaje de Erro: ' . $e->getMessage() . ' con el codigo: ' . $e->getCode();
        }

    }



}