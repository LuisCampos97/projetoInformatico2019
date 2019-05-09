<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Curso;

class CursoController extends Controller
{
    public function getCursosParaUserLogado($role)
    {
        $nome_curso = str_replace(substr($role, 0, 15), '', $role);

        $curso = Curso::where('nome_curso', $nome_curso)->first();
        
        return $curso;
    }
}
