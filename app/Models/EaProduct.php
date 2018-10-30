<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EaProduct extends Model
{
    protected $fillable = ['ea_id', 'ea_name','user_id', 'parameter'];
    protected $table = 'ea_products';
}