<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
        return User::withTrashed()->get();
    }
    
    public function registarNaBD(Request $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'unidade_organica' => $request->unidade_organica,
            'role' => $request->role,
            'roleDB' => $request->roleDB
        ]);
        $token = $user->createToken('TutsForWeb')->accessToken;
        return response()->json(['token' => $token]);
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        $user->roleDB = $request->getContent();
        $user->save();

        return response()->json($user, 200);
    }

    public function getBlocked($id){
        //dd($id);
        $user = User::findOrFail($id);
        $user->blocked = 1;
        $user->delete();
        $user->save();
        return response()->json([$user, 200]);
    }

    public function getBlockByEmail($email) {
        $user = User::where('email', $email)->firstOrFail();
        $user->blocked = 1;
        $user->delete();
        $user->save();
        return response()->json([$user, 200]);
    }

    public function getUnblocked($id){
        //dd($id);
        $user = User::withTrashed()->findOrFail($id);
        $user->blocked = 0;
        $user->deleted_at = NULL;
        $user->save();
        return response()->json([$user, 200]);
    }

    public function generateLog(Request $request) {
        Log::channel('syslog')->alert($request->message);  
    }
}
