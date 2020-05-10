<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provincy extends Model
{
    /**
     * The table that are selection
     *
     * @var array
     */
    protected $table = "provinces";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
