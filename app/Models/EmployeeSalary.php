<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeSalary extends Model
{
    /**
     * The table that are selection
     *
     * @var array
     */
    protected $table = "employee_salaries";

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'salary', 'salary_extra',
        'salary_total', 'status', 'description'
    ];
}
