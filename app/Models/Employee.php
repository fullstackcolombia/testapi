<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
	
	protected $table = 'employee';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'dni',
        'date_of_birth',
        'photo',
        'user_id',
    ];
	
	/**
     * Get the user_id associated with the user.
     */
    public function user_id()
    {
        return $this->hasOne(User::class,'user_id');
    }
	
	/**
     * The jobtitles that belong to the job title.
     */
    public function jobtitles()
    {
        return $this->belongsToMany(Jobtitle::class, 'employee_jobtitle', 'employee_id', 'jobtitle_id');
    }
}
