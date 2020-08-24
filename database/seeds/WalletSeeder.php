<?php

use Illuminate\Database\Seeder;
use App\Models\Wallet;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $wallets = [
            ['user_id' => 1, 'balance' => 1000],
            ['user_id' => 2, 'balance' => 2500]
        ];

        foreach ($wallets as $wallet) {
            Wallet::updateOrCreate([
                'user_id'   => $wallet['user_id'],
                'balance'   => $wallet['balance'],
            ]);
        }
    }
}
