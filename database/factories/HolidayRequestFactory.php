<?php

namespace Database\Factories;

use App\Models\HolidayRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class HolidayRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HolidayRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstname' => $this->faker->name,
            'lastname' => $this->faker->lastName,
            'phone_number' => $this->faker->numberBetween(0,999999999),
            'email' => $this->faker->unique()->safeEmail,
            'start_date' => now(),
            'end_date' => Carbon::now()->add('days',10),
        ];
    }
}
