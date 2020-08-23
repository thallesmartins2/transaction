<?php

use Illuminate\Database\Seeder;
use App\Models\TransactionType;


class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactions_type = [
            ['name' => 'lojista'],
            ['name' => 'comum']
        ];

        foreach ($transactions_type as $transaction_type) {
            TransactionType::updateOrCreate([
                'name'   => $transaction_type['name'],
            ]);
        }
    }
}
