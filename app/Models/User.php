<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	
	/**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
	
	/**
     * Get the employee.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
	
	/**
     * Create email.
     */
    public function create_email($param1,$param2,$domain = '@test.com')
    {
		$param1 = strtolower($param1);
        $param2 = strtolower($param2);
		$fullname = $param1.$param2;
		$iter = strlen($fullname) >= 3?3:strlen($fullname);//Validamos que el iterador no sea mayor a la cadena de texto
		$out = substr($fullname, 0, $iter).$domain;
		while($this->exist_email($out)){
			$iter++;
			$out = strlen($fullname) >= $iter?substr($fullname, 0, $iter).$domain:$fullname.rand(0,9);//validamos que ya no queden caracteres en el nombre proporcionado
		}
		return $out;
    }
	/**
     * Create email.
     */
    private function exist_email($email)
    {
		return $this->where('email', $email)->count();
    }
}
