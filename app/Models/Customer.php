<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * The table that are selection
     *
     * @var array
     */
    protected $table = "customers";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id', 'name', 'address', 'regency_id',
        'province_id', 'postcode', 'email', 'phone',
        'description'
    ];
}
