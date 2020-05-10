<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * The table that are selection
     *
     * @var array
     */
    protected $table = "employees";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'branch_id', 'name', 'birthplace', 'birthdate',
        'address', 'regency_id', 'province_id', 'postcode',
        'email', 'phone', 'salary','description'
    ];
}
