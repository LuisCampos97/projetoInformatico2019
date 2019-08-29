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
Route::post('/loginAdmin', 'Auth\LoginController@loginAdmin')->name('loginAdmin');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

//---------------Departamentos------------------------------------
Route::get('/departamento/{userDepName}', 'DepartamentoController@departamentoUserLogado');

//--------------------Unidades Curriculares-----------------------

Route::get('/unidadesCurriculares', 'UnidadeCurricularController@all');
Route::get('/unidadeCurricularNome/{codigo_uc}', 'UnidadeCurricularController@getNomeUc');
Route::get('/unidadesCurricularesDoCursoSelecionado/{codigo_curso}', 'UnidadeCurricularController@getUcsParaCurso');
Route::get('/tiposUnidadesCurriculares/{codigo_uc}', 'UnidadeCurricularController@getTipoUC');

//-----------------------------Cursos----------------------------------
Route::get('/lerCursosEUcs', 'CursoController@lerCursosEUcs');

//-----------------------Proposta Proponente----------------------------------------
Route::post('/propostaProponente', 'PropostaProponenteController@store');
Route::get('/allPropostasProponente', 'PropostaProponenteController@getPropostasProponente');
Route::get('/coordenadorDepartamento/propostasPendentes', 'PropostaProponenteController@getPropostasPendentesCoordenadorDepartamento');
Route::get('/coordenadorDepartamento/historicoPropostas', 'PropostaProponenteController@getHistoricoPropostasCoordenadorDepartamento');
Route::get('/coordenadorCurso/propostasPendentes', 'PropostaProponenteController@getPropostasPendentesCoordenadorCurso');
Route::get('/coordenadorCurso/historicoPropostas', 'PropostaProponenteController@getHistoricoPropostasCoordenadorCurso');
Route::put('/propostaProponente/fundamentacaoCoordenadorDepartamento/{propostaID}', 'PropostaProponenteController@inserirFundamentacaoCoordenadorDepartamento');
Route::put('/propostaProponente/fundamentacaoCoordenadorCurso/{propostaID}', 'PropostaProponenteController@inserirFundamentacaoCoordenadorCurso');
Route::get('/getProponentesQueIniciamPropostas', 'PropostaProponenteController@getProponentesQueIniciamPropostas');
Route::get('/getPropostaPorTipoDeDocente', 'PropostaProponenteController@getPropostaPorTipoDeDocente');
Route::get('/getPropostasNoUltimoMes', 'PropostaProponenteController@getPropostasNoUltimoMes');
Route::get('/getTipoDeContrato', 'PropostaProponenteController@getTipoDeContrato');

//-----------------------UcsPropostaProponente-------------------------------------------
Route::post('/ucsPropostaProponente' ,'UcsPropostaProponenteController@store');
Route::get('/getUcsPropostaProponente/{idProposta}', 'UcsPropostaProponenteController@getUcsPropostaProponente');

//----------------------Proposta Proponente Professor-------------------------------------------
Route::post('/propostaProponenteProfessor', 'PropostaProponenteProfessorController@store');
Route::get('/propostaProponenteProfessor/{idPropostaProponente}', 'PropostaProponenteProfessorController@getProposta');

//----------------------Proposta Proponente Assistente---------------------------------------------
Route::post('/propostaProponenteAssistente', 'PropostaProponenteAssistenteController@store');
Route::get('/propostaProponenteAssistente/{idPropostaProponente}', 'PropostaProponenteAssistenteController@getProposta');

//----------------------PropostaProponenteMonitor------------------------------------------------
Route::post('/propostaProponenteMonitor', 'PropostaProponenteMonitorController@store');
Route::get('/propostaProponenteMonitor/{idPropostaProponente}', 'PropostaProponenteMonitorController@getProposta');

//-----------------------Proposta-------------------------------------------------------------
Route::post('/proposta/{idParaUcsPropostaProponente}', 'PropostaController@inserirPropostaProponenteID');
Route::patch('/proposta/{idPropostaDiretorUO}/{propostaID}/{parecer}', 'PropostaController@atualizarPropostaDiretor');
Route::patch('/propostaCTC/{idPropostaCTC}/{propostaID}/{aprovacao}', 'PropostaController@atualizarPropostaCTC');
Route::patch('/propostaSecretariadoDirecao/{propostaSecretariadoDirecaoID}/{propostaID}', 'PropostaController@atualizarPropostaSecretariadoDirecao');
Route::patch('/propostaRecursosHumanos/{propostaRecursoHumanosID}/{propostaID}', 'PropostaController@atualizarPropostaRecursosHumanos');
Route::get('/propostas', 'PropostaController@all');
Route::get('/propostaDePropostaProponente/{propostaID}', 'PropostaController@getPropostaDePropostaProponente');
Route::put('updateFicheirosDocente/{propostaID}', 'PropostaController@updateFicheirosDocente');

//-----------------------Cursos---------------------------------------------------------------
Route::get('/cursosDisponiveis', 'CursoController@getCursos');

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
Route::get('/ficheiros/{proposta_id}', 'FicheiroController@getFicheiros');
Route::get('/downloadFicheiro/{proposta_id}/{descricao}', 'FicheiroController@downloadFicheiro');

//-------------------------Secretariado Direcao---------------------------------------------------
Route::get('/secretariadoDirecao/getPropostasPendentesSecretariadoDirecao', 'SecretariadoDirecaoController@getPropostasPendentes');
Route::get('/secretariadoDirecao/getHistoricoPropostasSecretariadoDirecao', 'SecretariadoDirecaoController@getHistoricoPropostas');
Route::post('/secretariadoDirecao/propostaSecretariadoDirecao', 'SecretariadoDirecaoController@store');

//-------------------------Recursos Humanos ----------------------------------------------------------
Route::get('/recursosHumanos/getPropostasPendentesRecursosHumanos', 'RecursosHumanosController@getPropostasPendentes');
Route::get('/recursosHumanos/getHistoricoPropostasRecursosHumanos', 'RecursosHumanosController@getHistoricoPropostas');
Route::post('/recursosHumanos/propostaRecursosHumanos', 'RecursosHumanosController@store');

//_--------------------------Users--------------------------------------------------------------
Route::post('/users/criarUserTemporario', 'UserController@store');
Route::get('/users', 'UserController@all');
Route::post('/users/criarUserTemporario', 'UserController@registarNaBD');
Route::put('/users/updateRole/{id}', 'UserController@updateRole');

//-------------------------------------------Novos Docentes--------------------------------------------
Route::get('/getPropostaParaNovoDocente/{emailDocente}', 'NovoDocenteController@getProposta');
