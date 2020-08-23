<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $table = 'transaction_type';

    protected $fillable = [
        'wallet_id',
        'transaction_type_id',
        'amount',
    ];

    public static function getAll()
    {
        return 'Chegou na Model Transaction metodo getAll';
    }

    public static function putTransaction($request)
    {
        return $request->all();
    }

    public static function getTransictionById($id)
    {
        return $id;
    }
    
    public static function editTransactionById($id)
    {
        return $id;
    }

    public static function updateTransactionById($request, $id) 
    {
        return $request->all();
    }

    public static function deleteTransactionById($id) 
    {
        return $id;
    }
}