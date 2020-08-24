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
        $payeeWallet = WebService::request('get', $request->payee, null, $request->BearerToken());
        $payerWallet = WebService::request('get', $request->payer, null, $request->BearerToken());
        try {
            if($this->getAuthorization()) {
                if ($this->checkComumUserType($payerWallet)) {
                    if ($this->checkBalance($payerWallet, $request)) {
                        //cria nova transação de débito
                        $newDebitTransaction = $this->createDebitTransaction($payerWallet->id, self::DEBITO, $request->value);
                        // realiza débito no carteira
                        $newDebitWallet = WebService::request('put', $payerWallet->id, ['value' => -$request->value], $request->BearerToken());
                        // cria nova transação de crédito
                        $newCreditTransaction = $this->createCreditTransaction($payeeWallet->id, self::CREDITO, $request->value);
                        // realiza credito na carteira
                        $newCreditWallet = WebService::request('put', $payeeWallet->id, ['value' => $request->value], $request->BearerToken());
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
            $this->rollBackWallet($payeeWallet, $payerWallet, $request->BearerToken());
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

    public function rollBackWallet($payeeWallet, $payerWallet, $token)
    {
        $wallets = ['payeeWallet' => $payeeWallet, 'payerWallet' => $payerWallet];
        return WebService::rollBackTransaction('post',  env('WALLET').'rollback', $wallets, $token);
    }

    public function checkBalance($payerWallet, $request)
    {
        return $retVal = $payerWallet->balance >= $request->value ? true : false ;
    }

    public function checkComumUserType($payerWallet)
    {
        return $payerWallet->user_type == 'comum' ? true : false;
    }

    public function getAuthorization()
    {
        $request = WebService::requestAutorization('get', 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
        if (json_decode($request->getBody()->getContents())->message == 'Autorizado' || $request->getStatusCode() == 200) {
            return true;
        } else {
            return false;
        }
    }

    public function createDebitTransaction($payerWallet, $debito, $value)
    {
        return $this->transactionRepository->storeTransaction(
            [
                'wallet_id' => $payerWallet, 
                'transaction_type_id' => $debito, 
                'amount' => $value
            ]
        );
    }

    public function createCreditTransaction($payeeWallet, $credito, $value)
    {
        return $this->transactionRepository->storeTransaction(
            [
                'wallet_id' => $payeeWallet, 
                'transaction_type_id' => $credito, 
                'amount' => $value
            ]
        );
    }
}
