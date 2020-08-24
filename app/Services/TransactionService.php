<?php

namespace App\Services;

use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Classes\WebService;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    private $transactionRepository;

    protected const DEBITO = 1;
    protected const CREDITO = 2;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    } 

    public function getAll()
    {
        return $this->transactionRepository->getAll();
    }

    public function setTransaction($request)
    {
        $payee_wallet = WebService::request('get', $request->payee, null, $request->BearerToken());
        $payer_wallet = WebService::request('get', $request->payer, null, $request->BearerToken());
        try {
            if($this->getAuthorization()) {
                if ($this->checkComumUserType($payer_wallet)) {
                    if ($this->checkBalance($payer_wallet, $request)) {
                        //cria nova transação de débito
                        $new_debit_transaction = $this->createDebitTransaction($payer_wallet->id, self::DEBITO, $request->value);
                        // realiza débito no carteira
                        $new_debit_wallet = WebService::request('put', $payer_wallet->id, ['value' => -$request->value], $request->BearerToken());
                        // cria nova transação de crédito
                        $new_credit_transaction = $this->createCreditTransaction($payee_wallet->id, self::CREDITO, $request->value);
                        // realiza credito na carteira
                        $new_credit_wallet = WebService::request('put', $payee_wallet->id, ['value' => $request->value], $request->BearerToken());
                        return $this->notificationAfterTransfer();
                    } else {
                        return ['mensagem' => 'Usuário não possui saldo'];
                    }
                } else {
                    return ['mensagem' => 'Usuário Logista não pode realizar transações'];
                }   
            } else {
                return ['mensagem' => 'Não autorizado'];
            }
        } catch (\Throwable $th) {
            $this->rollBackWallet($payee_wallet, $payer_wallet, $request->BearerToken());
            return ['mensagem' => 'Erro ao executar a transação! Nenhuma transação foi executada!'];
        }
    }

    public function getTransactionById($id)
    {
        return $this->transactionRepository->getTransactionById($id);
    }

    public function updateTransactionById($request, $id) 
    {
        return $this->transactionRepository->updateTransactionById($request, $id);
    }

    public function deleteTransactionById($id) 
    {
        return $this->transactionRepository->deleteTransactionById($id);
    }

    //-----

    public function notificationAfterTransfer()
    {
        return WebService::notification('get', 'https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04');
             
    }

    public function rollBackWallet($payee_wallet, $payer_wallet, $token)
    {
        $wallets = ['payee_wallet' => $payee_wallet, 'payer_wallet' => $payer_wallet];
        return WebService::rollBackTransaction('post', 'http://172.17.0.1:8001/api/wallet/rollback', $wallets, $token);
    }

    public function checkBalance($payer_wallet, $request)
    {
        return $retVal = $payer_wallet->balance >= $request->value ? true : false ;
    }

    public function checkComumUserType($payer_wallet)
    {
        return $payer_wallet->user_type == 'comum' ? true : false;
    }

    public function getAuthorization()
    {
        $request = WebService::requestAutorization('get', 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
        if (json_decode($request->getBody()->getContents())->message == 'Autorizado' || $request->getStatusCode()) {
            return true;
        } else {
            return false;
        }
    }

    public function createDebitTransaction($payer_wallet, $debito, $value)
    {
        return $this->transactionRepository->storeTransaction(
            [
                'wallet_id' => $payer_wallet, 
                'transaction_type_id' => $debito, 
                'amount' => $value
            ]
        );
    }

    public function createCreditTransaction($payee_wallet, $credito, $value)
    {
        return $this->transactionRepository->storeTransaction(
            [
                'wallet_id' => $payee_wallet, 
                'transaction_type_id' => $credito, 
                'amount' => $value
            ]
        );
    }
}
