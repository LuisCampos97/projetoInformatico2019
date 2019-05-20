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
Route::get('/departamento/{userDepName}', 'DepartamentoController@departamentoUserLogado');

//--------------------Unidades Curriculares-----------------------

Route::get('/unidadesCurriculares', 'UnidadeCurricularController@all');
Route::get('/unidadeCurricularNome/{codigo_uc}', 'UnidadeCurricularController@getNomeUc');
Route::get('/unidadesCurricularesDoCursoSelecionado/{codigo_curso}', 'UnidadeCurricularController@getUcsParaCurso');
Route::get('/unidadesCurriculares/regime/{codigo_uc}', 'UnidadeCurricularController@getRegimesParaUC');
Route::get('/unidadesCurriculares/turno/{uc_name}/{uc_regime}', 'UnidadeCurricularController@getTurnosParaUCeRegime');
Route::get('/tiposUnidadesCurriculares/{codigo_uc}', 'UnidadeCurricularController@getTipoUC');

//-----------------------------Cursos----------------------------------
Route::get('/lerCursosEUcs', 'CursoController@lerCursosEUcs');

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
Route::patch('/proposta/{idPropostaDiretorUO}/{propostaID}', 'PropostaController@atualizarPropostaDiretor');
Route::patch('/propostaCTC/{idPropostaCTC}/{propostaID}', 'PropostaController@atualizarPropostaCTC');
//-----------------------Cursos---------------------------------------------------------------
Route::get('/cursosDisponiveis/{role}', 'CursoController@getCursosParaUserLogado');

//-----------------------Diretor UO----------------------------------------------------------
Route::get('/diretorUO/propostasPendentes', 'DiretorUOController@getPropostasPendentes');
Route::get('/diretorUO/getPropostaProponente/{role}/{proposta_proponente_id}', 'DiretorUOController@getTipoPropostaRole');
Route::get('/diretorUO/getUCSPropostaSelecionada/{proposta_proponente_id}', 'DiretorUOController@getUCSPropostaSelecionada');
Route::post('/diretorUO/propostaDiretor', 'DiretorUOController@store');
Route::get('/diretorUO/historicoPropostas', 'DiretorUOController@getHistoricoPropostas');

//--------------------------CTC-----------------------------------------------------------
Route::get('/ctc/getPropostasPendentesCTC', 'CTCController@getPropostasPendentes');
Route::post('/ctc/propostaCTC', 'CTCController@store');
Route::get('/ctc/getHistoricoPropostasCTC', 'CTCController@getHistoricoPropostasCTC');

//-------------------------Ficheiros-----------------------------------------------
Route::post('/ficheiro', 'FicheiroController@store');