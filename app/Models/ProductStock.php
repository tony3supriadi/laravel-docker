<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    /**
     * The table that are selection
     *
     * @var array
     */
    protected $table = "product_stocks";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'branch_id', 'stock_status',
        'stock_nominal', 'stock_saldo', 'description'
    ];
}
