<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationalOther extends Model
{
    /**
     * The table that are selection
     *
     * @var array
     */
    protected $table = "operational_others";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nominal', 'description'
    ];
}
