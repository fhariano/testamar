<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $cost = fake()->randomDigitNotZero();

        return [
            'name' => fake()->text(45),
            'description' => fake()->text(100),
            'sale_price' => $cost * 1.15,
            'cost_price' => $cost,
            'user_id' => User::where('email', 'admin@example.com')->first()->id,
        ];
    }
}
