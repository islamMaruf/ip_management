<?php

namespace Database\Factories;

use App\Models\IP;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class IPFactory extends Factory
{
    protected $model = IP::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ip' => $this->faker->ipv4(),
            'comment' => $this->faker->text(150)
        ];
    }
}
