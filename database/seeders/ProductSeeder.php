<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 2. Crear datos de prueba para la tabla products
        DB::table('products')->insert([
            'name' => 'Laptop Asus',
            'description' => 'Laptop para Gamers',
            'price' => 1560
        ]);

        DB::table('products')->insert([
            'name' => 'Mouse Loguitech',
            'description' => 'Mouse para Gamers',
            'price' => 205
        ]);

        DB::table('products')->insert([
            'name' => 'Teclado Loguitech',
            'description' => 'Teclado para Gamers',
            'price' => 150
        ]);
    }
}
