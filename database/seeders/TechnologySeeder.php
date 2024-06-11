<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Technology;
use Illuminate\Support\Str;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $techs = ['scss', 'js', 'laravel', 'tailwind', 'vue', 'bs5'];

        foreach($techs as $tech){
            $newTech = new Technology();
            $newTech->name = $tech;
            $newTech->slug = Str::slug($tech, "-");
            $newTech->save();
        }
    }
}
