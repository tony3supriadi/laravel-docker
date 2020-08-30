<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    /**
     * The table that are selection
     *
     * @var array
     */
    protected $table = "sales";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice', 'customer_id', 'branch_id', 'price_total',
        'status', 'description', 'is_barter', 'jml_barter',
        'metode_pembayaran'
    ];
}
