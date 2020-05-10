<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Regency extends Model
{
    /**
     * The table that are selection
     *
     * @var array
     */
    protected $table = "regencies";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'province_id', 'name'
    ];
}
