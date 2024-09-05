<?php

declare(strict_types=1);

namespace Guava\Sequence\Database\Factories;

use Guava\Sequence\Models\SequencePeriod;
use Illuminate\Database\Eloquent\Factories\Factory;

class SequencePeriodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SequencePeriod::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'date' => $this->faker->dateTimeBetween('-1 year')->format('Y-m-d'),
            'ordinal_number' => $this->faker->numberBetween(1, 100),
        ];
    }
}
