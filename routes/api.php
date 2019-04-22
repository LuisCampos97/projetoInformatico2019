<?php

use Illuminate\Http\Request;
use App\Http\Resources\UnidadeCurricular;
use App\Http\Controllers\UnidadeCurricularController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'Auth\LoginController@login')->name('login');

//---------------Departamentos------------------------------------
Route::get('/departamentos', 'DepartamentoController@all');

//--------------------Unidades Curriculares-----------------------

Route::get('/unidadesCurriculares', 'UnidadeCurricularController@all');
Route::get('/unidadesCurricularesDoDepartamentoSelecionado/{dep_id}', 'UnidadeCurricularController@getUcsParaDepartamento');
Route::get('/unidadesCurriculares/{uc_id}', 'UnidadeCurricularController@getUcParaId');

//_----------------Propostas diretor UO-------------------------------
Route::get('/propostaDiretorUO/historico', 'DiretorUOController@getHistoricoPropostas');
Route::get('/propostaDiretorUO/propostasPendentes', 'DiretorUOController@getPropostasPendentes');