<?php

namespace Database\Factories;

use App\Models\Rsvp;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rsvp>
 */
class RsvpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hasAllergies = $this->faker->boolean();

        return [
            'user_id' => User::factory(),
            'badge_name' => $this->faker->optional()->firstName(),
            'attending' => $this->faker->boolean(),
            'has_allergies' => $hasAllergies,
            'allergies' => $hasAllergies ? $this->faker->sentence() : null,
            'bringing' => $this->faker->optional()->sentence(),
            'bringing_music_equipment' => $this->faker->boolean(),
            'drinking_alcohol' => $this->faker->boolean(),
            'bringing_fursuit' => $this->faker->boolean(),
            'is_vegetarian' => $this->faker->boolean(),
            'is_vegan' => $this->faker->boolean(),
        ];
    }
}
