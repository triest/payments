<?php

namespace Database\Factories;

use Closure;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = User::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
                'name' => $this->faker->name,
                'email' => $this->faker->safeEmail,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'balance'=>$this->faker->randomDigit(),
                'remember_token' => Str::random(10),
        ];
    }
}
