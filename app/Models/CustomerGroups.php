<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerGroups extends Model
{
    /**
     * The table that are selection
     *
     * @var array
     */
    protected $table = "customer_groups";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'branch_id', 'name', 'description'
    ];
}
