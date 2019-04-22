<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        
    }


    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|max:255'
        ]);
        
        $user =  User::where('email', $request->email)->first();

        if(Crypt::decrypt($user->password) ==  $request->password){
            $user->api_token = str_random(60);   
            $user->update();         
            return ['api_token' => $user->api_token];

        }else{
            return new Response('Email ou Senha inválidos!',401);
        }
        
    }


    public function index()
    {
        return User::all(); 
    }


    public function store(Request $request)
    {
        $this->validate($request, [
        'name' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|min:6|confirmed|max:255'
        ]);

        $user = new User($request->all());
        $user->password = Crypt::encrypt($request->password);
        $user->api_token = str_random(60);
        $user->save();
        return $user;
    }


    public function update(Request $request,$id)
    {
        $data_validation = [
            'name' => 'required|max:255',
            'email' => 'required|unique:users|max:255'
        ];


        if ($request->has('password')) {
            $data_validation['password'] = 'required|confirmed|max:255';
        }

        $this->validate($request,$data_validation);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->has('password')) {
            $user->password = Crypt::encrypt($request->password);
        }

        $user->update();
        return $user;
    }

    public function show($id)
    {      
        return User::find($id);
    }

    public function delete($id)
    {     
    
        if(User::destroy($id)){
            return new Response('Removido com sucessoo!',200);
        }else{
            return new Response('Erro ao remover!',401);
        } 
    }

}
