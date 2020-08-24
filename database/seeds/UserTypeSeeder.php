<?php

use Illuminate\Database\Seeder;
use App\Models\UserType;

class UserTypeSeeder extends Seeder
{
    public function run()
    {
        $users_type = [
            ['name' => 'lojista'],
            ['name' => 'comum']
        ];

        foreach ($users_type as $user_type) {
            UserType::updateOrCreate([
                'name'   => $user_type['name'],
            ]);
        }
    }
}