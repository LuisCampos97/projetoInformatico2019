<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\UnidadeCurricular;

class UnidadeCurricularController extends Controller
{
    public function all()
    {
        $ucs = DB::table('unidade_curricular')->get();
        return $ucs;
    }

    public function getNomeUc($codigo_uc)
    {
        return UnidadeCurricular::where('codigo', $codigo_uc)->first()->nome;
    }

    public function getUcsParaCurso($codigo_curso)
    {
        $ucs = DB::table('unidade_curricular')
            ->where('codigo_curso', '=', $codigo_curso)
            ->get();

        return $ucs;
    }

    public function getRegimesParaUC($codigo_uc)
    {
        $regimes = DB::table('turnos_uc')
            ->where('codigo_uc', '=', $codigo_uc)
            ->select('regime')
            ->distinct('regime')
            ->get();

        return $regimes;
    }

    public function getTurnosParaUCeRegime($codigo_uc, $uc_regime)
    {
        $turnos = DB::table('turnos_uc')
            ->where('codigo_uc', '=', $codigo_uc)
            ->where('regime', '=', $uc_regime)
            ->get();

        return $turnos;
    }

    public function getTipoUC($codigo_uc)
    {
        $tipo = DB::table('unidade_curricular')
            ->where('codigo', '=', $codigo_uc)
            ->select('tipo')
            ->distinct('tipo')
            ->get();

        return $tipo;
    }
}
