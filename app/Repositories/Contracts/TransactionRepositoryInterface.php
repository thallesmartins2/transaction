<?php

namespace App\Repositories\Contracts;

interface TransactionRepositoryInterface
{
    public function getAll();

    public function storeTransaction(array $transaction);

    public function getTransactionById($id);

    public function editTransactionById($id);

    public function updateTransactionById($request, $id);

    public function deleteTransactionById($id);
}