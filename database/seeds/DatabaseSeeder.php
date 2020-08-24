<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(TransactionTypeSeeder::class);
        $this->call(UserTypeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(WalletSeeder::class);
        $this->call(TransactionSeeder::class);
    }
}
