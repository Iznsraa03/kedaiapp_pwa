<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        static $counter = 10;
        $counter++;

        return [
            'name'               => fake()->name(),
            'email'              => fake()->unique()->safeEmail(),
            'nra'                => 'KDA-' . str_pad($counter, 3, '0', STR_PAD_LEFT),
            'role'               => 'member',
            'email_verified_at'  => now(),
            'password'           => static::$password ??= Hash::make('password'),
            'remember_token'     => Str::random(10),
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

    /**
     * Set role as admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    /**
     * Set role as member (regular user).
     */
    public function member(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'member',
        ]);
    }

    /**
     * Alias for member state to keep usage intuitive.
     */
    public function user(): static
    {
        return $this->member();
    }

    /**
     * Fixed dummy admin account.
     */
    public function dummyAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'name'     => 'Admin KedaiApp',
            'email'    => 'admin@kedaiapp.com',
            'nra'      => 'KDA-001',
            'role'     => 'admin',
            'password' => Hash::make('admin@kedai2026'),
        ]);
    }

    /**
     * Fixed dummy regular account.
     */
    public function dummyUser(): static
    {
        return $this->state(fn (array $attributes) => [
            'name'     => 'Dummy User',
            'email'    => 'user@kedaiapp.com',
            'nra'      => 'KDA-002',
            'role'     => 'member',
            'password' => Hash::make('user@kedai2026'),
        ]);
    }
}
