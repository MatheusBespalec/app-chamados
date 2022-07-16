<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attack>
 */
class AttackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'description' => $this->faker->text($this->faker->numberBetween(20, 40)),
            'url' => preg_replace('/^(.*):\/\/(.*)\//', '/', $this->faker->url(), 1)
        ];
    }
}
