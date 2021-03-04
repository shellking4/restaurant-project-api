<?php

namespace Database\Factories;

use App\Models\Drink;
use Illuminate\Database\Eloquent\Factories\Factory;

class DrinkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Drink::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(20),
            'description' => $this->faker->text,
            'image' => $this->faker->image('public/drImages', 400, 300, null, false),
            'price' => $this->faker->randomFloat(5)
        ];
    }
}
