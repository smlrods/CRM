<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'description' => fake()->text(),
            'due_date' => fake()->dateTimeBetween('+1 day', '+1 week')->format('Y-m-d'),
            'status' => fake()->randomElement([
                "Not Started",
                "In Progress",
                "On Hold",
                "Completed",
                "Delayed",
                "Blocked",
                "Cancelled",
                "Needs Review",
                "High Priority",
                "Low Priority",
            ]),
        ];
    }
}
