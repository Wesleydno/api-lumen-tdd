<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //
    public function store(Request $request){
        $this->validate($request, [
        'name' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|min:6|max:255'
        ]);

        $user = new User($request->all());
        $user->save();
        return $user;
    }

    public function show($id){
        
        return User::find($id);
    }

    public function update($id){
        
    }
}
