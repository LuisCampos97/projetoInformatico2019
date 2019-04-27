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
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

//---------------Departamentos------------------------------------
Route::get('/departamentos', 'DepartamentoController@all');

//--------------------Unidades Curriculares-----------------------

Route::get('/unidadesCurriculares', 'UnidadeCurricularController@all');
Route::get('/unidadesCurricularesDoDepartamentoSelecionado/{dep_id}', 'UnidadeCurricularController@getUcsParaDepartamento');
Route::get('/unidadesCurriculares/regime/{uc_name}', 'UnidadeCurricularController@getRegimesParaUC');
Route::get('/unidadesCurriculares/{uc_name}/{uc_regime}', 'UnidadeCurricularController@getTurnosParaUCNomeeRegime');
Route::get('/tiposUnidadesCurriculares/{uc_name}', 'UnidadeCurricularController@getTipoUC');

//-----------------------Proposta Proponente----------------------------------------
Route::post('/propostaProponente', 'PropostaProponenteController@store');

//-----------------------UcsPropostaProponente-------------------------------------------
Route::post('/ucsPropostaProponente' ,'UcsPropostaProponenteController@store');

//----------------------Proposta Proponente Professor-------------------------------------------
Route::post('/propostaProponenteProfessor', 'PropostaProponenteProfessorController@store');

//----------------------Proposta Proponente Assistente---------------------------------------------
Route::post('/propostaProponenteAssistente', 'PropostaProponenteAssistenteController@store');

//----------------------PropostaProponenteMonitor------------------------------------------------
Route::post('/propostaProponenteMonitor', 'PropostaProponenteMonitorController@store');

//-----------------------Proposta-------------------------------------------------------------
Route::post('/proposta/{idParaUcsPropostaProponente}', 'PropostaController@inserirPropostaProponenteID');

