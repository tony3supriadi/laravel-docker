<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shopping extends Model
{
    /**
     * The table that are selection
     *
     * @var array
     */
    protected $table = "shoppings";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'supplier_id', 'price_total', 'status',
        'description'
    ];
}
