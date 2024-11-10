<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Videogames>
 */
class VideogamesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>$this->faker->name(),
            'description'=>$this->faker->text(),
            'type'=>$this->faker->name(),
            'genre'=>$this->faker->name(),
            'image'=> '/img/example.jpg'
        ];
    }
}
