<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuarios
        Usuario::factory()
            ->withUsername('tester')
            ->withPassword('123')
            ->withRole('manager')
        ->create();

        Usuario::factory()
            ->withUsername('tester2')
            ->withPassword('123')
            ->withRole('agent')
        ->create();
    }
}
