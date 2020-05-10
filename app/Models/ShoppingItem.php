<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShoppingItem extends Model
{
    /**
     * The table that are selection
     *
     * @var array
     */
    protected $table = "shopping_items";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shopping_id', 'supplier_id', 'product_id',
        'price', 'count_item', 'sub_total', 'description'
    ];
}
