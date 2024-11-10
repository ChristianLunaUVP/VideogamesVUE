<?php

namespace Database\Seeders;

use App\Models\Videogames;
use App\Models\Platforms;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crea 25 plataformas y 15 videojuegos
        Platforms::factory(25)->create();
        Videogames::factory(15)->create();
        
        // Asocia cada videojuego con una plataforma aleatoria
        foreach (Videogames::all() as $videogame) {
            $videogame->platforms()->attach([
                'platform_id' => rand(1, 25)
            ]);
        }
    }
}
