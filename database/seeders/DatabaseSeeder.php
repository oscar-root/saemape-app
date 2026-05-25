<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
   
    public function run(): void
    {
        // On appelle le seeder des rôles ici !
        $this->call([
            RoleUserSeeder::class,
        ]);

        // Optionnel : un utilisateur de test général
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'admin',
        ]);
    }
}