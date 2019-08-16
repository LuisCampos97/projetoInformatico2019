<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'role' => 'required',
            'roleDB' => 'required',
            'email' => 'required|email',
            'unidade_organica' => 'required',
            'blocked' => 'required',
        ]);

        
        $user = new User();
        
        $user->fill($request->all());
        $user->password = Hash::make($request->passwsord);   
        //dd($user);
        $user->save();
        return response()->json($user, 200);
    }

    public function all() {
        return User::all();
    }
}
