<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UsuarioFactory extends Factory
{
    protected static $role;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => $this->faker->userName(),
            'password' => Hash::make('password'),
            'last_login' => now(),
            'is_active' => true,
            'role' => static::$role
        ];
    }

    /**
     * Especificar un username para el usuario.
     *
     * @param string $username
     * @return $this
     */
    public function withUsername($username)
    {
        return $this->state([
            'username' => $username,
        ]);
    }

    /**
     * Especificar una contraseña para el usuario.
     *
     * @param string $password
     * @return $this
     */
    public function withPassword($password)
    {
        return $this->state([
            'password' => Hash::make($password),
        ]);
    }

    /**
     * Especificar un rol para el usuario.
     *
     * @param manager|agent $role
     * @return $this
     */
    public function withRole($role)
    {
        return $this->state([
            'role' => $role,
        ]);
    }

}
