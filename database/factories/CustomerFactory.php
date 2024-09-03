<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'age' => $this->faker->numberBetween(18, 80),
            'dob' => $this->faker->date('Y-m-d', '2004-01-01'), // Example: Max date is set to 2004-01-01 to ensure age is realistic
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
