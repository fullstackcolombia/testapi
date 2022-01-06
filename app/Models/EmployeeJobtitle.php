<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EmployeeJobtitle extends Pivot
{
    protected $table = 'employee_jobtitle';
	
	public $incrementing = true;
}
