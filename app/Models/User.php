<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $table = 'user';

    protected $fillable = [
        'name', 'cpf_cnpj', 'email', 'user_type_id', 'password'
    ];
}
