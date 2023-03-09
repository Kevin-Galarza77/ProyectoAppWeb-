<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cabecera_Pedidos;
use App\Models\Categoria;
use App\Models\Detalle_Pedido;
use App\Models\Estados_Pedidos;
use App\Models\EstadoUser;
use App\Models\Producto;
use App\Models\rol;
use App\Models\SubCategoria;
use App\Models\TipoEntrega_Pedidos;
use App\Models\User;
use App\Models\usuarios;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        EstadoUser::factory(2)->create();
        User::factory(100)->create();
        rol::factory(2)->create();
        usuarios::factory(10)->create();
        Estados_Pedidos::factory(2)->create();
        TipoEntrega_Pedidos::factory(2)->create();
        Cabecera_Pedidos::factory(5)->create();
        Categoria::factory(3)->create();
        SubCategoria::factory(4)->create();
        Producto::factory(50)->create();
        Detalle_Pedido::factory(200)->create();
    }
}
