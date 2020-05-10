<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShoppingPayment extends Model
{
    /**
     * The table that are selection
     *
     * @var array
     */
    protected $table = "shopping_payments";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shopping_id', 'supplier_id', 'billing',
        'payment', 'debit', 'description'
    ];
}
