<?php

namespace Database\Factories;

use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $lecturer = Lecturer::inRandomOrder()->firstOrCreate();
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'lecturer_id' => $lecturer->id
        ];
    }
}
