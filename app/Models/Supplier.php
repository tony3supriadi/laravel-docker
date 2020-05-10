<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    /**
     * The table that are selection
     *
     * @var array
     */
    protected $table = "suppliers";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'branch_id', 'name', 'address', 'regency_id',
        'province_id', 'postcode', 'email', 'phone',
        'telp', 'faxmail', 'bank_id', 'bank_number',
        'bank_account', 'description'
    ];
}
