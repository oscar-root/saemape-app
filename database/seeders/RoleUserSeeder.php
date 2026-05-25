<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        // Création d'un échantillon d'utilisateurs par rôle
        $users = [
            ['name' => 'Admin SAEMAPE', 'email' => 'admin@saemape.cd', 'role' => 'admin', 'matricule' => 'ADM-01'],
            ['name' => 'Délégué Mineur', 'email' => 'delegue@saemape.cd', 'role' => 'delegue', 'matricule' => 'DEL-01'],
            ['name' => 'Agent Accueil', 'email' => 'agent@saemape.cd', 'role' => 'agent', 'matricule' => 'AGT-01'],
            ['name' => 'Dir Provincial', 'email' => 'dipro@saemape.cd', 'role' => 'dipro', 'matricule' => 'DIR-01'],
        ];

        foreach ($users as $u) {
            User::create([
                'name' => $u['name'],
                'email' => $u['email'],
                'role' => $u['role'],
                'matricule' => $u['matricule'],
                'password' => Hash::make('password'), // Mot de passe identique pour les tests
            ]);
        }
    }
}