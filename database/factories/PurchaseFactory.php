<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'=>fake()->word(),
            'category_id'=>fake()->numberBetween(1,3),
            'net_price'=>fake()->numberBetween(1000,90000),
            'salling_price'=>fake()->numberBetween(2000,100000),
            'quantity'=>fake()->numberBetween(2,40),
            'image'=>fake()->image(),
            'expiry_date'=>fake()->date(),
            'supplier_id'=>fake()->numberBetween(1,5),
            'paracode'=>fake()->numberBetween(1111111111,999999999),
        ];
    }
}
