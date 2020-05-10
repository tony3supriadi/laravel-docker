<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The table that are selection
     *
     * @var array
     */
    protected $table = "companies";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address', 'regency_id', 'province_id',
        'postcode', 'email', 'phone', 'telp', 'website',
        'facebook', 'twitter', 'instagram', 'description'
    ];
}
