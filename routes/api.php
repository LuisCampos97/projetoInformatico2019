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
Route::post('/criarUC', 'UnidadeCurricularController@criarUC');

//-----------------------------Cursos----------------------------------
Route::get('/lerCursosEUcs', 'CursoController@lerCursosEUcs');
Route::post('/criarCurso', 'CursoController@criarCurso');

//-----------------------Proposta Proponente----------------------------------------
Route::post('/propostaProponente', 'PropostaProponenteController@store');
Route::put('/updatePropostaProponente/{idProposta}', 'PropostaProponenteController@update');
Route::get('/allPropostasProponente', 'PropostaProponenteController@getPropostasProponente');
Route::get('/coordenadorDepartamento/propostasPendentes', 'PropostaProponenteController@getPropostasPendentesCoordenadorDepartamento');
Route::get('/coordenadorDepartamento/historicoPropostas', 'PropostaProponenteController@getHistoricoPropostasCoordenadorDepartamento');
Route::get('/coordenadorCurso/propostasPendentes', 'PropostaProponenteController@getPropostasPendentesCoordenadorCurso');
Route::get('/coordenadorCurso/historicoPropostas', 'PropostaProponenteController@getHistoricoPropostasCoordenadorCurso');
Route::put('/propostaProponente/fundamentacaoCoordenadorDepartamento/{propostaID}', 'PropostaProponenteController@inserirFundamentacaoCoordenadorDepartamento');
Route::put('/propostaProponente/fundamentacaoCoordenadorCurso/{propostaID}', 'PropostaProponenteController@inserirFundamentacaoCoordenadorCurso');
Route::get('/verificarSeJaExistemPropostasAtivasParaDocenteASerContratado/{email}', 'PropostaProponenteController@verificarSeJaExistemPropostasAtivasParaDocenteASerContratado');
Route::put('/apagarPropostasProponente/{idProposta}', 'PropostaProponenteController@apagarPropostasProponente');

//? Estatisticas
Route::get('/getPropostasProponente/{idProponente}', 'PropostaProponenteController@getPropostasDoProponente');
Route::get('/getPropostasPorTipoDeDocente/{idProponente}', 'PropostaProponenteController@getPropostasPorTipoDeDocente');
Route::get('/getPropostasPorTipoDeContrato/{idProponente}', 'PropostaProponenteController@getPropostasPorTipoDeContrato');
Route::get('/getPropostasNoUltimoMes/{idProponente}', 'PropostaProponenteController@getPropostasNoUltimoMes');


//-----------------------UcsPropostaProponente-------------------------------------------
Route::post('/ucsPropostaProponente' ,'UcsPropostaProponenteController@store');
Route::delete('/ucsPropostaProponente/{idUcPropostaProponente}', 'UcsPropostaProponenteController@delete');
Route::get('/getUcsPropostaProponente/{idProposta}', 'UcsPropostaProponenteController@getUcsPropostaProponente');

//----------------------Proposta Proponente Professor-------------------------------------------
Route::post('/propostaProponenteProfessor', 'PropostaProponenteProfessorController@store');
Route::put('/updatePropostaProponenteProfessor/{idPropostaProponenteProfessor}', 'PropostaProponenteProfessorController@update');
Route::get('/propostaProponenteProfessor/{idPropostaProponente}', 'PropostaProponenteProfessorController@getProposta');

//----------------------Proposta Proponente Assistente---------------------------------------------
Route::post('/propostaProponenteAssistente', 'PropostaProponenteAssistenteController@store');
Route::put('/updatePropostaProponenteAssistente/{idPropostaProponenteAssistente}', 'PropostaProponenteAssistenteController@update');
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

//? Estatisticas
Route::get('/diretorUO/getPropostas/{idDiretorUO}', 'DiretorUOController@getPropostas');
Route::get('/diretorUO/getPropostasPorTipoParecer/{idDiretorUO}', 'DiretorUOController@getPropostasPorTipoParecer');

//--------------------------CTC-----------------------------------------------------------
Route::get('/ctc/getPropostasPendentesCTC', 'CTCController@getPropostasPendentes');
Route::post('/ctc/propostaCTC', 'CTCController@store');
Route::get('/ctc/getHistoricoPropostasCTC', 'CTCController@getHistoricoPropostasCTC');

//? Estatisticas
Route::get('/ctc/getPropostas/{idCTC}', 'CTCController@getPropostas');
Route::get('/ctc/getPropostasPorTipoParecer/{idCTC}', 'CTCController@getPropostasPorTipoParecer');

//-------------------------Ficheiros-----------------------------------------------
Route::post('/ficheiro', 'FicheiroController@store');
Route::get('/ficheiros/{proposta_id}', 'FicheiroController@getFicheiros');
Route::delete('/deleteFicheiros/{proposta_id}', 'FicheiroController@deleteFicheiros');
Route::get('/downloadFicheiro/{proposta_id}/{descricao}', 'FicheiroController@downloadFicheiro');

//-------------------------Secretariado Direcao---------------------------------------------------
Route::get('/secretariadoDirecao/getPropostasPendentesSecretariadoDirecao', 'SecretariadoDirecaoController@getPropostasPendentes');
Route::get('/secretariadoDirecao/getHistoricoPropostasSecretariadoDirecao', 'SecretariadoDirecaoController@getHistoricoPropostas');
Route::post('/secretariadoDirecao/propostaSecretariadoDirecao', 'SecretariadoDirecaoController@store');

//? Estatisticas
Route::get('/secretariadoDirecao/getPropostas/{idSecretariadoDirecao}', 'SecretariadoDirecaoController@getPropostas');

//-------------------------Recursos Humanos ----------------------------------------------------------
Route::get('/recursosHumanos/getPropostasPendentesRecursosHumanos', 'RecursosHumanosController@getPropostasPendentes');
Route::get('/recursosHumanos/getHistoricoPropostasRecursosHumanos', 'RecursosHumanosController@getHistoricoPropostas');
Route::post('/recursosHumanos/propostaRecursosHumanos', 'RecursosHumanosController@store');

//? Estatisticas
Route::get('/recursosHumanos/getPropostas/{idRecursosHumanos}', 'RecursosHumanosController@getPropostas');

//_--------------------------Users--------------------------------------------------------------
Route::post('/users/criarUserTemporario', 'UserController@store');
Route::get('/users', 'UserController@all');
Route::post('/users/criarUserTemporario', 'UserController@registarNaBD');
Route::put('/users/updateRole/{id}', 'UserController@updateRole');
Route::put('/block/{id}', 'UserController@getBlocked');
Route::put('/unblock/{id}', 'UserController@getUnblocked');


//-------------------------------------------Novos Docentes--------------------------------------------
Route::get('/getPropostaParaNovoDocente/{emailDocente}', 'NovoDocenteController@getProposta');
