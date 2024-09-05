<?php

declare(strict_types=1);

namespace Guava\Sequence\Database\Factories;

use Guava\Sequence\Enums\ResetFrequency;
use Guava\Sequence\Models\SequenceRule;
use Illuminate\Database\Eloquent\Factories\Factory;
use InvalidArgumentException;

class SequenceRuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SequenceRule::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' => $this->faker->unique()->word(),
            'reset_frequency' => $this->faker->randomElement(ResetFrequency::getValues()),
            'pattern' => function (array $attributes) {
                return $this->faker->randomElement(
                    $this->examplePatterns($attributes['reset_frequency'])
                );
            },
        ];
    }

    /**
     * Get example patterns for given reset frequency
     *
     * @return array<string>
     */
    private function examplePatterns(string $resetFrequency): array
    {
        switch ($resetFrequency) {
            case ResetFrequency::DAILY:
                return ['{number}/{day}/{month}/{year}', '{month}/{day}/{year}/{number}', '{number}/{day_short}{month_short}{year_short}'];

            case ResetFrequency::MONTHLY:
                return ['{number}/COMPANY/{month}/{year}', '{month_short}/{year}/{number}', '{number}/{month}-{year_short}'];

            case ResetFrequency::YEARLY:
                return ['{number}/EXAMPLE/{year}', '{year}-{number}', '{number}/{year_short}'];
        }

        throw new InvalidArgumentException('Invalid reset frequency value.');
    }

    /**
     * Indicate that sequence should resets daily.
     */
    public function resetsDaily(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'reset_frequency' => ResetFrequency::DAILY,
            ];
        });
    }

    /**
     * Indicate that sequence should resets monthly.
     */
    public function resetsMonthly(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'reset_frequency' => ResetFrequency::MONTHLY,
            ];
        });
    }

    /**
     * Indicate that sequence should resets yearly.
     */
    public function resetsYearly(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'reset_frequency' => ResetFrequency::YEARLY,
            ];
        });
    }
}
