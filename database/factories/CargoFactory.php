<?php

namespace Database\Factories;

use App\Models\Cargo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CargoFactory extends Factory
{
    protected $model = Cargo::class;

    public function definition(): array
    {
        return [
            // Sender info
            's_name'        => $this->faker->name,
            's_phone'       => $this->faker->phoneNumber,
            's_nrc'         => strtoupper(Str::random(10)),
            's_address'     => $this->faker->address,

            // Receiver info
            'r_name'        => $this->faker->name,
            'r_phone'       => $this->faker->phoneNumber,
            'r_nrc'         => strtoupper(Str::random(10)),
            'r_address'     => $this->faker->address,

            // Cargo details
            'cargo_no'      => 'CARGO-' . strtoupper(Str::random(6)),
            'from_city'     => $this->faker->city,
            'to_city'       => $this->faker->city,
            'from_gate'     => 'Gate ' . $this->faker->numberBetween(1, 5),
            'to_gate'       => 'Gate ' . $this->faker->numberBetween(1, 5),
            'quantity'      => $this->faker->numberBetween(1, 10),
            'cargo_type'    => $this->faker->randomElement(['Box', 'Bag', 'Parcel']),
            'media_id'      => null,
            'status'        => $this->faker->randomElement(['registered', 'delivered', 'taken', 'lost']),

            // Financials
            'service_charge'    => $this->faker->randomFloat(2, 1000, 10000),
            'short_deli_fee'    => $this->faker->randomFloat(2, 500, 2000),
            'final_deli_fee'    => $this->faker->randomFloat(2, 500, 3000),
            'border_fee'        => $this->faker->randomFloat(2, 0, 1000),
            'total_fee'         => $this->faker->randomFloat(2, 2000, 15000),

            // Payment
            'is_short_fee_paid' => $this->faker->boolean,
            'is_final_fee_paid'  => $this->faker->boolean,

            // Cash
            'instant_cash'      => $this->faker->randomFloat(2, 0, 10000),
            'loan_cash'         => $this->faker->randomFloat(2, 0, 10000),

            // Logistics
            'to_pick_date'      => $this->faker->optional()->dateTimeBetween('-1 week', '+1 week'),
            'voucher_number'    => strtoupper('VCH-' . Str::random(8)),

            // Notes
            'note'              => $this->faker->optional()->sentence,
        ];
    }
}
