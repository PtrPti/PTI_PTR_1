<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\GrupoFicheiros;
use App\TarefasFicheiros;
use App\ProjetoFicheiro;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
    
Auth::routes();
    
Route::get('/home', 'HomeController@index')->name('home');

Route::get('locale/{lang}', )->name('languages');

Route::get('locale/{lang}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});
    
//Login
Route::get('/login', 'AuthController@getLogin')->name('login');

//Registo
Route::get('/registar', 'AuthController@getRegistar')->name('registar');
Route::post('/registarAluno', 'AuthController@registarAluno')->name('registarAluno');
Route::post('/registarProfessor', 'AuthController@registarProfessor')->name('registarProfessor');
Route::get('/registar/getCursos', 'AuthController@changeDepartamentoId')->name('changeDepartamentoId');
Route::get('/registar/getCadeirasAluno', 'AuthController@changeCursoId')->name('changeCursoId');
Route::get('/registar/getCadeirasProf', 'AuthController@changeDepartamentoProfId')->name('changeDepartamentoProfId');

//Perfil
Route::get('/Home/Perfil/{tab?}', 'PerfilController@perfilDocente')->name('perfil');
Route::post('/changePass', 'PerfilController@changePass')->name('changePass');
Route::post('/profile', 'PerfilController@updateAvatar')->name('profile_update');
Route::post('/changeNome', 'PerfilController@changeNome')->name('changeNome');
Route::post('/changeEmail', 'PerfilController@changeEmail')->name('changeEmail');

//---------------- ADMIN ----------------//
Route::get('/Admin', 'AdminController@home')->name('homeAdmin')->middleware('checkUserRole:3');
Route::get('/Admin/AnosLetivos', 'AdminController@getAnosLetivos')->name('getAnosLetivos')->middleware('checkUserRole:3');
Route::get('/Admin/Semestres', 'AdminController@getSemestres')->name('getSemestres')->middleware('checkUserRole:3');
Route::get('/Admin/Departamentos', 'AdminController@getDepartamentos')->name('getDepartamentos')->middleware('checkUserRole:3');
Route::get('/Admin/Cursos', 'AdminController@getCursos')->name('getCursos')->middleware('checkUserRole:3');
Route::get('/Admin/Disciplinas', 'AdminController@getCadeiras')->name('getCadeiras')->middleware('checkUserRole:3');
Route::get('/Admin/Disciplinas/{id}', 'AdminController@editCadeiraForm')->name('editCadeiraForm')->middleware('checkUserRole:3');
Route::get('/Admin/Utilizadores', 'AdminController@getUtilizadores')->name('getUtilizadores')->middleware('checkUserRole:3');
Route::get('/Admin/Utilizadores/{id}', 'AdminController@editUserForm')->name('editUserForm')->middleware('checkUserRole:3');

Route::get('editAnoLetivo', 'AdminController@editAnoLetivo')->middleware('checkUserRole:3');
Route::post('editAnoLetivoPost', 'AdminController@editAnoLetivoPost')->middleware('checkUserRole:3');
Route::post('addAnoLetivoPost', 'AdminController@addAnoLetivoPost')->middleware('checkUserRole:3');

Route::get('editSemestre', 'AdminController@editSemestre')->middleware('checkUserRole:3');
Route::post('editSemestrePost', 'AdminController@editSemestrePost')->middleware('checkUserRole:3');
Route::post('addSemestrePost', 'AdminController@addSemestrePost')->middleware('checkUserRole:3');

Route::get('editUser', 'AdminController@editUser')->middleware('checkUserRole:3');
Route::post('editUserPost', 'AdminController@editUserPost')->name('editUserPost')->middleware('checkUserRole:3');
Route::post('addUserPost', 'AdminController@addUserPost')->middleware('checkUserRole:3');

Route::get('editDepartamento', 'AdminController@editDepartamento')->middleware('checkUserRole:3');
Route::post('editDepartamentoPost', 'AdminController@editDepartamentoPost')->middleware('checkUserRole:3');
Route::post('addDepartamentoPost', 'AdminController@addDepartamentoPost')->middleware('checkUserRole:3');

Route::get('editCurso', 'AdminController@editCurso')->middleware('checkUserRole:3');
Route::post('editCursoPost', 'AdminController@editCursoPost')->middleware('checkUserRole:3');
Route::post('addCadeiraPost', 'AdminController@addCadeiraPost')->middleware('checkUserRole:3');

Route::get('editCadeira', 'AdminController@editCadeira')->middleware('checkUserRole:3');
Route::post('editCadeiraPost', 'AdminController@editCadeiraPost')->name('editCadeiraPost')->middleware('checkUserRole:3');
Route::post('addCadeiraPost', 'AdminController@addCadeiraPost')->middleware('checkUserRole:3');

Route::post('addDepartamentoCsv', 'AdminController@addDepartamentoCsv')->name('addDepartamentoCsv')->middleware('checkUserRole:3');
Route::post('addCursosCsv', 'AdminController@addCursosCsv')->name('addCursosCsv')->middleware('checkUserRole:3');
Route::post('addCadeirasCsv', 'AdminController@addCadeirasCsv')->name('addCadeirasCsv')->middleware('checkUserRole:3');
Route::post('addAnoLetivoCsv', 'AdminController@addAnoLetivoCsv')->name('addAnoLetivoCsv')->middleware('checkUserRole:3');
Route::post('addSemestreCsv', 'AdminController@addSemestreCsv')->name('addSemestreCsv')->middleware('checkUserRole:3');
Route::post('addUserCsv', 'AdminController@addUserCsv')->name('addUserCsv')->middleware('checkUserRole:3');

Route::get('getSemestres/{id}', 'AdminController@changeAnoLetivoId')->middleware('checkUserRole:3');
Route::get('getCursos/{id}', 'AdminController@changeDepartamentoId')->middleware('checkUserRole:3');
Route::get('getDisciplinas/{id}', 'AdminController@changeCursoId')->middleware('checkUserRole:3');

Route::get('searchCadeiras', 'AdminController@searchCadeiras')->middleware('checkUserRole:3');
Route::get('searchAnosLetivos', 'AdminController@searchAnosLetivos')->middleware('checkUserRole:3');
Route::get('searchSemestres', 'AdminController@searchSemestres')->middleware('checkUserRole:3');
Route::get('searchDepartamentos', 'AdminController@searchDepartamentos')->middleware('checkUserRole:3');
Route::get('searchCursos', 'AdminController@searchCursos')->middleware('checkUserRole:3');
Route::get('searchUsers', 'AdminController@searchUsers')->middleware('checkUserRole:3');

Route::post('lockUser', 'AdminController@lockUser')->middleware('checkUserRole:3');
Route::post('unlockUser', 'AdminController@unlockUser')->middleware('checkUserRole:3');

Route::get('exportAnosLetivosExcel', 'AdminController@exportUsersExcel')->name('exportUsersExcel')->middleware('checkUserRole:3');
Route::get('exportSemestresExcel', 'AdminController@exportUsersExcel')->name('exportUsersExcel')->middleware('checkUserRole:3');
Route::get('exportDepartamentosExcel', 'AdminController@exportUsersExcel')->name('exportUsersExcel')->middleware('checkUserRole:3');
Route::get('exportCursosExcel', 'AdminController@exportUsersExcel')->name('exportUsersExcel')->middleware('checkUserRole:3');
Route::get('exportDisciplinasExcel', 'AdminController@exportUsersExcel')->name('exportUsersExcel')->middleware('checkUserRole:3');
Route::get('exportUsersExcel', 'AdminController@exportUsersExcel')->name('exportUsersExcel')->middleware('checkUserRole:3');
Route::get('exportExcel', 'AdminController@exportExcel')->name('exportExcel')->middleware('checkUserRole:3');

//---------------- NOVO ----------------//
Route::get('/Home', 'HomeController@home')->name('home');
Route::get('/filterProj', 'HomeController@filterProj');
Route::post('/changeFavorito', 'HomeController@changeFavorito');

Route::get('/Home/Disciplina/{id}/{tab?}/{proj?}', 'DisciplinaController@index')->name('disciplina');
Route::post('criarProjeto', 'DisciplinaController@criarProjeto');
Route::post('addFileProjeto', 'DisciplinaController@addFileProjeto')->name('addFileProjeto');
Route::post('addLinkProjeto', 'DisciplinaController@addLinkProjeto');

Route::get('showGrupos', 'DisciplinaController@showGrupos');
Route::post('addGrupo', 'DisciplinaController@addGrupo');
Route::post('deleteGrupo','DisciplinaController@deleteGrupo');
Route::post('removeUser', 'DisciplinaController@removeUser');
Route::post('addUser', 'DisciplinaController@addUser');

Route::post('addForumTopico', 'DisciplinaController@addForumTopico');
Route::get('verMensagensForum', 'DisciplinaController@verMensagensForum');
Route::post('replyForum', 'DisciplinaController@replyForum');
Route::post('createEvaluation', 'DisciplinaController@addEvaluation')->name('createEvaluation');
Route::get('verAvaliacaoDisciplina', 'DisciplinaController@verAvaliacaoDisciplina');
Route::post('/changeEvaluation', 'DisciplinaController@changeEvaluation')->name('changeEvaluation');
Route::post('/eraiseEvaluation', 'DisciplinaController@eraiseEvaluation')->name('eraiseEvaluation');

Route::get('/search_alunos', 'DisciplinaController@search_alunos')->name('search_alunos');
Route::post('/addAluno', 'DisciplinaController@addAluno')->name('addAluno');

Route::get('/search_projeto', 'HomeController@search_projetos')->name('search_projeto');

Route::get('/Home/Projeto/Grupo/{id}/{tab?}', 'ProjetoController@index')->name('projeto'); #id = grupo_id

Route::post('createTarefa', 'ProjetoController@createTarefa');
Route::post('createPasta', 'ProjetoController@createPasta');
Route::post('addFileGrupo', 'ProjetoController@addFileGrupo')->name('addFileGrupo');
Route::post('addNotaGrupo', 'ProjetoController@addNotaGrupo');
Route::post('addLinkGrupo', 'ProjetoController@addLinkGrupo');

Route::get('pesquisarTarefas', 'ProjetoController@pesquisarTarefas');
Route::get('editTarefa', 'ProjetoController@editTarefa');
Route::post('editTarefaPost', 'ProjetoController@editTarefaPost');
Route::post('checkTarefa', 'ProjetoController@checkTarefa');

Route::post('addFileTarefa', 'ProjetoController@addFileTarefa')->name('addFileTarefa');
Route::post('addLinkTarefa', 'ProjetoController@addLinkTarefa');
Route::post('addNotaTarefa', 'ProjetoController@addNotaTarefa');

Route::get('verFeedback', 'ProjetoController@verFeedback');
Route::post('createFeedback', 'ProjetoController@createFeedback');
Route::post('sendFeedback', 'ProjetoController@sendFeedback');
Route::post('addMensagemFeedbackDocente', 'ProjetoController@addMensagemFeedbackDocente');

Route::post('addAvaliacao', 'ProjetoController@addAvaliacao')->name('addAvaliacao');
Route::post('avaliar', 'ProjetoController@avaliar')->name('avaliar');
Route::get('infoNota', 'ProjetoController@infoNota');
Route::get('saveNota', 'ProjetoController@saveNota');

Route::get('remover', 'ProjetoController@remover');

//---------------- CHAT ----------------//
Route::get('{route?}/alunomessage/{id}', 'ChatController@getMessage')->name('getmessage');
Route::get('/alunomessage/{id}', 'ChatController@getMessage')->name('getmessage');
Route::get('/getUsers', 'ChatController@getUsersView')->name('getusers');
Route::get('/getUsersDocente', 'ChatController@getUsersViewDocente')->name('getUsersDocente');
Route::post('message', 'ChatController@sendMessage');

//---------------- DOWNLOAD ----------------//
//Download
Route::get('download/{id}/{local}', function($id, $local) {
    if ($local == 'grupo'){
      $ficheiro= GrupoFicheiros::where('id', $id)->first();
    }
    elseif ($local == 'tarefa'){
      $ficheiro= TarefasFicheiros::where('id', $id)->first();
    }
    elseif ($local == 'projeto'){
      $ficheiro= ProjetoFicheiro::where('id', $id)->first();
    }
  
      //$file_path = Storage::disk('s3')->url($ficheiro->nome);
      //$file_path = storage_path() .'/app/public/' . $folder . '/'. $filename;
      if ( Storage::disk('s3')->has($ficheiro->nome)) {
          //$name = explode("_", $filename, 2)[1];
            $headers = [
              //'Content-Type'        => 'application/x-httpd-php',
              'Content-Disposition' => 'attachment; filename="'. $ficheiro->nome .'"',
            ];
          return Response::make(Storage::disk('s3')->get($ficheiro->nome), 200, $headers);
      }
      else {
          exit('Requested file does not exist on our server!');
      }
  })->where('filename', '[A-Za-z0-9\-\_\.]+');

//---------------- CALENDARIO ----------------//
Route::get('/calendar/loadEvents/{grupo_id}', 'CalendarController@load')->name('loadEvents');
Route::post('/calendar/createEvent/{title}/{start}/{end}/{allDay}/{grupo_id}', 'CalendarController@create')->name('createEvent');
Route::post('/calendar/updateEvents/{id}/{title}/{start}/{end}/{allDay}', 'CalendarController@update')->name('updateEvents');
Route::post('/calendar/deleteEvents/{id}', 'CalendarController@delete')->name('deleteEvents');

