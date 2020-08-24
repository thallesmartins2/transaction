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
}