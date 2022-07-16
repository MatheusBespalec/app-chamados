<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Error>
 */
class ErrorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'code' => $this->faker->randomDigit(),
            'message' => $this->faker->text(80),
            'file' => $this->faker->file(storage_path('debugbar')),
            'line' => $this->faker->numberBetween(0, 100),
            'url' => preg_replace('/^(.*):\/\/(.*)\//', '/', $this->faker->url(), 1),
            'trace' => json_encode(debug_backtrace()),
            'status' => $this->faker->numberBetween(0, 2),
        ];
    }
}
