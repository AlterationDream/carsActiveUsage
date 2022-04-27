<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([[
            'name' => 'Василий Яшкин',
        ],[
            'name' => 'Игнатий Кесадильев'
        ],[
            'name' => 'Геннадий Шеcтаков'
        ], [
            'name' => 'Александр Булкин'
        ]]);

        DB::table('cars')->insert([[
            'name' => 'Mazda CX-5 - о505мо 78'
        ],[
            'name' => 'Chevrolet Malibu - к103кк 77'
        ],[
            'name' => 'Honda Civic - с065мк 86'
        ],[
            'name' => 'Toyota Camry - а482ас 34'
        ]]);

        DB::table('active_uses')->insert([[
            'user_id' => 2,
            'car_id' => 3
        ],[
            'user_id' => 1,
            'car_id' => 2
        ]]);
    }
}
