<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginAdmin(Request $request)
    {
        if (empty($request->email) || empty($request->password)) {
            return response()->json([
                'errorMessage' => 'Os dados inseridos estão inválidos!',
            ], 401);
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $user = User::where('email', $request->email)->first();

        if (auth()->attempt($credentials) && $user->roleDB == 'admin') {
            $token = auth()->user()->createToken('TutsForWeb')->accessToken;
            $arrayADevolver = [];
            $arrayADevolver["token"] = $token;
            $arrayADevolver["user"] = $user;
            return response()->json($arrayADevolver, 200);
        }

        return response()->json(['error' => 'UnAuthorised'], 401);

    }

    public function login(Request $request)
    {
        if (empty($request->email) || empty($request->password)) {
            return response()->json([
                'errorMessage' => 'Os dados inseridos estão inválidos!',
            ], 401);
        }

        if (strpos($request->email, '@my.ipleiria.pt') !== false || strpos($request->email, '@ipleiria.pt') !== false) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $token = Str::random(60);
                $response = compact('token');
                $response['user'] = Auth::user();
                $role = \Adldap\Laravel\Facades\Adldap::search()->find($request->email)->title[0];
                $user = User::where('email', $request->email)->first();
                if (strpos($role, 'Departamento') !== false  || strpos($role, 'Estudante') !== false) {
                    $user->roleDB = 'proponente_departamento';
                    $user->save();
                } elseif (strpos($role, 'Curso') !== false) {
                    $user->roleDB = 'proponente_curso';
                    $user->save();
                } elseif (strpos($role, 'Diretor') !== false) {
                    $user->roleDB = 'diretor_uo';
                    $user->save();
                } elseif (strpos($role, 'Conselho') !== false) {
                    $user->roleDB = 'ctc';
                    $user->save();
                } elseif (strpos($role, 'Secretariado') !== false) {
                    $user->roleDB = 'secretariado_direcao';
                    $user->save();
                } elseif (strpos($role, 'Recursos') !== false) {
                    $user->roleDB = 'recursos_humanos';
                    $user->save();
                }

                return $response;
            }
        } else {
            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            if (auth()->attempt($credentials)) {
                $token = auth()->user()->createToken('TutsForWeb')->accessToken;
                $user = User::where('email', $request->email)->first();
                $arrayADevolver = [];
                $arrayADevolver["token"] = $token;
                $arrayADevolver["user"] = $user;
                return response()->json($arrayADevolver, 200);
            }

            return response()->json(['error' => 'UnAuthorised'], 401);
        }

        return response()->json([
            'errorMessage' => 'As credenciais estão inválidas. Por
            favor tente novamente',
        ], 401);
    }

    public function logout()
    {
        $this->guard()->logout();

        return response()->json([
            'errorMessage' => 'Logout with success.',
        ], 200);
    }
}
