<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\Jobtitle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$this->middleware('auth');
		$o_all = Employee::all();
		$lista = [];
		foreach($o_all as $key => $row){
			$out = [];
			$iter = $key+1;
			array_push($out,$iter);
			array_push($out,$row->name);
			array_push($out,$row->dni);
			array_push($out,User::findOrFail($row->user_id)->email);
			array_push($lista,$out);
		}
		return \response(['data' => $lista]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->middleware('auth');
		$validatedData = $request->validate([
			'name' => 'required|string',
			'lastname' => 'required|string',
			'dni' => 'required|string|min:6',
		],[
			'name.required' => 'El nombre es requerido',
			'lastname.required' => 'El apellido es requerido',
			'dni.required' => 'El DNI es requerido',
		]);
		//users - name,lastname,email,password
		$user = new User(['name' => $request->name,'lastname' => $request->lastname,'email' => '','password' => Hash::make($request->dni)]);
		//Generamos el correo
		$user->email = $user->create_email($request->name,$request->lastname);
		$user->save();
		//employee - name,lastname,dni,date_of_birth,photo,user_id
		$photo = '';
		if($request->has('photo')){
			$photo = $request->file('photo')->store('uploads','public');
		}
		$o = Employee::create(['name' => $request->name,'lastname' => $request->lastname,'dni' => $request->dni,'date_of_birth' => $request->date_of_birth,'photo' => $photo,'user_id' => $user->id]);
		//jobtitle - name,code,importance,is_boss
		$jobt = Jobtitle::create(['name' => $request->namejob,'code' => $request->code,'importance' => $request->importance,'is_boss' => $request->is_boss]);
		$o->jobtitles()->attach($jobt->id);//employee_jobtitle
		return \response($o);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
