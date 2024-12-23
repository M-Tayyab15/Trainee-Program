<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile2>
 */
class Profile2Factory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), 
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'country' => $this->faker->country(),
            'created_on' => $this->faker->unixTime(),
            'modified_on' => $this->faker->unixTime(),
            'ip_address' => $this->faker->ipv4(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
