<?php

use Illuminate\Database\Seeder;
use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactions = [
            ['wallet_id' => 1, 'transaction_type_id' => 1, 'amount'=> 100],
            ['wallet_id' => 1, 'transaction_type_id' => 2, 'amount'=> 200],
            ['wallet_id' => 2, 'transaction_type_id' => 1, 'amount'=> 100],
            ['wallet_id' => 2, 'transaction_type_id' => 2, 'amount'=> 130],
            ['wallet_id' => 2, 'transaction_type_id' => 2, 'amount'=> 2000]
        ];

        foreach ($transactions as $transaction) {
            Transaction::updateOrCreate([
                'wallet_id'   => $transaction['wallet_id'],
                'transaction_type_id'   => $transaction['transaction_type_id'],
                'amount'   => $transaction['amount']
            ]);
        }
    }
}