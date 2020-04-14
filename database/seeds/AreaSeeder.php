<?php

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = ["Programación","Emprendimiento","Marketing","Diseño"];

        foreach($areas as $area) {
            Area::create([
                "name" => $area
            ]);
        }

    }
}
