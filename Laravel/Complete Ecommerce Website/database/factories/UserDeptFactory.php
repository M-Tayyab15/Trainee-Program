<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class UserDeptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'id' => $this->faker->unique()->randomNumber(), 
            'name' => $this->faker->name(),
            'dept' => $this->faker->word(),
        ];
    }


    public function seed($count)
    {
        $data = [];

        for ($i = 0; $i < $count; $i++) {
            $data[] = $this->definition();
        }

        DB::table('user_dept')->insert($data);
    }
}
