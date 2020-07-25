<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    /**
     * The table that are selection
     *
     * @var array
     */
    protected $table = "sale_items";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sale_id', 'product_id', 'purchase_price', 'price',
        'qty', 'sub_total', 'description'
    ];
}
