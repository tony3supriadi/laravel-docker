<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerSaving extends Model
{
    protected $table = "customer_savings";

    protected $fillable = [
        'customer_id', 'code', 'description',
        'status', 'nominal', 'saldo'
    ];
}
