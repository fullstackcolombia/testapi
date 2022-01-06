<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobtitle extends Model
{
    use HasFactory;
	
	protected $table = 'jobtitle';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'importance',
        'is_boss',
    ];
	
	/**
     * The employeers that belong to the job title.
     */
    public function employeers()
    {
        return $this->belongsToMany(Employee::class, 'employee_jobtitle', 'jobtitle_id', 'employee_id');
    }
}
