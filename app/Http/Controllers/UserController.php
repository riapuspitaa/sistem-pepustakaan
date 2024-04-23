<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    
    public function index()
    {
    	$users = User::all();
    	$roles = Role::all();
    	return view('user.user_index', compact('users','roles'));
    }

    public function create()
    {
    	$roles = Role::all(); //mengambil semua role untuk form
    	return view('user.user_create', compact('roles'));
    }

    public function store(Request $request)
    {
    	$request->validate([
    		'name' => 'required|string|max:255',
    		'email' => 'required|email|unique:users,email',
    		'password' => 'required|string|min:8',
    		'roles' => 'required|array', //memastikan input roles adalah array
    	]);

    	$user = new User();
    	$user->name = $request->name;
    	$user->email = $request->email;
    	$user->password = bcrypt($request->name);
    	$user->save();

    	$user->assignRole($request->roles); //memberikan role yang dipilih kepada user

    	return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('user.user_edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        $user = User::findOrFail($id);
         $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'roles' => 'required|array',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        if($requset->password){
            $user->password = bcrypt($request->password);
        }
        $user->save();

        $user->syncRole($request->roles);
        //dd($request->all());
        return redirect()->route('users.update')->with('success', 'User berhasil diperbaharui');

    }
    public function hapus ($id)
    {
        $user = user::find($id);
        $user->delete();
        return redirect ('/user');
    }
}
