<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalePayment extends Model
{
    /**
     * The table that are selection
     *
     * @var array
     */
    protected $table = "sale_payments";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sale_id', 'customer_id', 'billing', 
        'payment', 'debit','description'
    ];
}
