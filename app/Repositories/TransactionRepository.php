<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    private $transaction;

    public function __construct()
    {
        $this->transaction = new Transaction;
    }

    public function getAll()
    {
        return $this->transaction::all();
    }

    public function storeTransaction(array $transaction)
    {
        return $this->transaction::create($transaction);
    }

    public function getTransactionById($id)
    {

    }

    public function editTransactionById($id)
    {

    }

    public function updateTransactionById($request, $id)
    {

    }

    public function deleteTransactionById($id)
    {

    }
}