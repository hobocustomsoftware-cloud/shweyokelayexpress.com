<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends Factory<Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'number' => $this->faker->unique()->regexify('[A-Z]{2}[0-9]{4}'),
            'departure_date' => $this->faker->dateTimeBetween('now', '+7 days')->format('Y-m-d'),
            'driver_name' => $this->faker->name(),
            'driver_phone_number' => $this->faker->phoneNumber(),
            'assistant_driver_name' => $this->faker->name(),
            'assistant_driver_phone' => $this->faker->phoneNumber(),
            'spare_name' => $this->faker->name(),
            'spare_phone' => $this->faker->phoneNumber(),
            'assistant_spare_name' => $this->faker->name(),
            'assistant_spare_phone' => $this->faker->phoneNumber(),
        ];
    }
}
