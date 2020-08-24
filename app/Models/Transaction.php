<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Classes\WebService;

class Transaction extends Model
{
    use SoftDeletes;

    protected $table = 'transaction';

    protected $fillable = [
        'wallet_id', 'transaction_type_id', 'amount'
    ];

    // public static function getAll()
    // {
    //     return self::all();
    // }

    // public static function storeTransaction($request)
    // {
    //     $payee_wallet = WebService::request('get', $request->payee);
    //     $payer_wallet = WebService::request('get', $request->payer);

        
    //     if ($payer_wallet->balance >= $request->value) {
    //         //cria nova transação de débito
    //         $transacao = self::create(['wallet_id' => $payer_wallet->id, 'transaction_type_id' => self::DEBITO, 'amount' => $request->value]);
    //         // realiza débito no carteira
    //         $debito = WebService::request('put', $payer_wallet->id, ['value' => -$request->value]);
    //         // cria nova transação de crédito
    //         $transacao = self::create(['wallet_id' => $payee_wallet->id, 'transaction_type_id' => self::CREDITO, 'amount' => $request->value]);
    //         // realiza credito na carteira
    //         $debito = WebService::request('put', $payee_wallet->id, ['value' => $request->value]);
    //         return 'transação efetuada';
    //     } else {
    //         return 'transações não efetuadas';
    //     }
    // }

    public static function getTransactionById($id)
    {
        return self::find($id);
    }
    
    public static function editTransactionById($id)
    {
        return $id;
    }

    public static function updateTransactionById($request, $id) 
    {
        return self::find($id)->update($request->all());
    }

    public static function deleteTransactionById($id) 
    {
        return self::find($id)->delete();
    }
}