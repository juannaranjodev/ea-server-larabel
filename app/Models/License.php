<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $fillable = ['ea_id', 'user_id', 'account_number', 'hash_key', 'allow_flag'];
    protected $table = 'licenses';
}
