<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Thalles', 
                'cpf_cnpj' => 444444444444, 
                'email' => 'thallesmartins2@hotmail.com', 
                'user_type_id' => 1, 
                'password' => '$2y$10$VMkyCdvXjGevIkppgHrD/OOxDLdJzQQJio8sIVn7d4qjBIpiYtMrG'
            ],
            [
                'name' => 'Raquel', 
                'cpf_cnpj' => 222222222222, 
                'email' => 'rquel@hotmail.com', 
                'user_type_id' => 2, 
                'password' => '$2y$10$VMkyCdvXjGevIkppgHrD/OOxDLdJzQQJio8sIVn7d4qjBIpiYtMrG'
            ]
        ];

        foreach ($users as $user) {
            User::updateOrCreate([
                'name'   => $user['name'],
                'cpf_cnpj'   => $user['cpf_cnpj'],
                'email'   => $user['email'],
                'user_type_id'   => $user['user_type_id'],
                'password'   => $user['password']
            ]);
        }
    }
}
