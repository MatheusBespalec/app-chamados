<?php

namespace Database\Factories;

use App\Models\Log;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Log>
 */
class LogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $httpMethods = ['POST', 'GET', 'PUT', 'PATCH', 'DELETE'];
        return [
            'var_server' => json_encode($_SERVER),
            'var_get' => json_encode($_GET),
            'var_post' => json_encode($_POST),
            'var_request' => json_encode($_REQUEST),
            'var_files' => json_encode($_FILES),
            'var_cookie' => json_encode($_COOKIE),
            'var_env' => json_encode($_ENV),
            'http_method' => $this->faker->numberBetween(0, count($httpMethods) - 1)
        ];
    }
}
