<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    /**
     * The table that are selection
     *
     * @var array
     */
    protected $table = "product_prices";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'group_id', 'branch_id',
        'price', 'description'
    ];
}
