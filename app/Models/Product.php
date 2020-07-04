<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The table that are selection
     *
     * @var array
     */
    protected $table = "products";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'unit_id', 'code', 'name', 'price',
        'purchase_price', 'stock', 'stockmin', 'image', 'description'
    ];
}
