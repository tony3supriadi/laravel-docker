<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    /**
     * The table that are selection
     *
     * @var array
     */
    protected $table = "branchs";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'name', 'address', 'regency_id',
        'province_id', 'postcode', 'email', 'phone',
        'telp', 'description'
    ];
}
