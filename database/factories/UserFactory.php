<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'prefixname' => $this->faker->optional()->title(),
            'firstname' => $this->faker->firstName(),
            'middlename' => $this->faker->optional()->firstName(),
            'lastname' => $this->faker->lastName(),
            'suffixname' => $this->faker->optional()->suffix(),
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'photo' => 'https://i.pravatar.cc/150?img=' . rand(1, 70),
            'type' => $this->faker->randomElement(['user', 'admin']),
            'remember_token' => Str::random(10),
            'email_verified_at' => $this->faker->optional()->dateTime(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}