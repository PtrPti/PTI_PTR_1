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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Login
Route::get('/login', 'AuthController@getLogin')->name('login');

//Registo
Route::get('/registar', 'AuthController@getRegistar')->name('registar');
Route::post('/registar', 'AuthController@postRegistar')->name('registarPost');
Route::get('/registar/getCursos', 'AuthController@changeDepartamentoId')->name('changeDepartamentoId');
Route::get('/registar/getCadeirasAluno', 'AuthController@changeCursoId')->name('changeCursoId');
Route::get('/registar/getCadeirasProf', 'AuthController@changeDepartamentoProfId')->name('changeDepartamentoProfId');

//---------------- DOCENTES ----------------//
//Home
Route::get('/docenteHome/{tab?}', 'HomeController@indexDocente')->name('homeDocente')->middleware('checkUserRole:2');
Route::post('/docenteHome/{redirect?}', 'HomeController@store')->name('projetoPost')->middleware('checkUserRole:2');
Route::get('/docenteHome', 'HomeController@perfil')->name('perfil')->middleware('checkUserRole:2');

//Disciplinas
Route::get('/docenteHome/disciplina/{id}/{tab?}', 'DisciplinaController@indexDocente')->name('indexDisciplinaDocente');
Route::get('addGrupo', 'DisciplinaController@addGrupo');
Route::get('verMensagensDocente', 'DisciplinaController@verMensagensDocente');
Route::get('showGrupos', 'DisciplinaController@showGrupos');
Route::get('getForum', 'DisciplinaController@getForum');
Route::get('getPagInicial', 'DisciplinaController@getPagInicial');
Route::post('uploadFile', 'DisciplinaController@uploadFile')->name('uploadFile');

//Projetos
Route::get('projetos', 'ProjetoController@nome_projetos')->name('projeto');
Route::get('projetos/{id}', 'ProjetoController@id_projetos')->name('id_projeto');
Route::get('delete-records','ProjetoController@index');
Route::get('delete/{id}','ProjetoController@eraseProject');
Route::post('/docenteHome/{route?}/deleteGrupo','ProjetoController@deleteGrupo');
Route::get('/projetos/grupo/{id}', 'ProjetoController@GrupoDocente')->name('GrupoDocente');
Route::post('/addmessages', 'ProjetoController@addmensagem')->name('AddMensagem');
Route::get('/showFeedback', 'ProjetoController@showFeedback')->name('ShowFeedback');

//Forum
Route::post('addTopicoDocente', 'DisciplinaController@addTopicoDocente')->name('addTopicoDocente');
Route::post('replyForum', 'DisciplinaController@replyForum')->name('replyForum');

//---------------- ALUNOS ----------------//
//Home
Route::get('/alunoHome/{tab?}', 'HomeController@indexAluno')->name('homeAluno')->middleware('checkUserRole:1');
Route::get('/alunoHome', 'HomeController@alunoHome')->name('alunoHome');
Route::get('/filterProj', 'HomeController@filterProj');
Route::post('/changeFavorito', 'HomeController@changeFavorito');
Route::get('/perfilAluno', 'HomeController@perfilAluno')->name('perfilAluno');
Route::post('/changeNome', 'HomeController@changeNome')->name('changeNome');
Route::post('/changeEmail', 'HomeController@changeEmail')->name('changeEmail');
Route::post('/changePass', 'HomeController@changePass')->name('changePass');

//Disciplina
Route::get('/disciplinasAluno/{cadeira_id}', 'DisciplinaController@pagDisciplina')->name('pagDisciplina')->middleware('checkUserRole:1');
Route::get('showGruposA', 'DisciplinaController@showGruposA');
Route::get('verMensagens', 'DisciplinaController@verMensagens');
Route::get('showForum', 'DisciplinaController@showForum');
Route::post('/addTopicoAluno', 'DisciplinaController@addTopicoAluno')->name('addTopicoAluno');
Route::post('/addMensagem', 'DisciplinaController@addMensagem');
Route::post('/removeUser', 'DisciplinaController@removeUser');
Route::post('/addUser', 'DisciplinaController@addUser');
Route::post('/addGroup', 'DisciplinaController@addGroup');
Route::post('/addUserGroup', 'DisciplinaController@addUserGroup');
Route::get('forum', 'DisciplinaController@Forum');

// Route::get('showGrup', 'DisciplinaController@showGrup');

//Projeto
Route::get('/projetosAluno/{id}/{tarefa_id?}', 'ProjetoController@pagProjeto')->name('pagProjeto')->middleware('checkUserRole:1');
Route::get('infoTarefa', 'ProjetoController@infoTarefa');
Route::get('alterarTarefa', 'ProjetoController@alterarTarefa');
Route::get('infoNota', 'ProjetoController@infoNota');
Route::get('saveNota', 'ProjetoController@saveNota');
Route::get('editTarefa', 'ProjetoController@editTarefa');
Route::get('eliminarFicheiro', 'ProjetoController@eliminarFicheiro');
Route::get('editAllTarefa', 'ProjetoController@editAllTarefa');
Route::get('addLink', 'ProjetoController@addLink');
Route::get('addLinkTarefa', 'ProjetoController@addLinkTarefa');
Route::get('addPasta', 'ProjetoController@addPasta');
Route::get('addFeedback', 'ProjetoController@addFeedback');
Route::get('feedbackVista', 'ProjetoController@feedbackVista');
Route::get('addNota', 'ProjetoController@addNota');
Route::get('addTarefa', 'ProjetoController@addTarefa');
Route::get('subTarefas', 'ProjetoController@subTarefas');
Route::get('addSubTarefa', 'ProjetoController@addSubTarefa');
Route::get('pesquisar', 'ProjetoController@pesquisar');
Route::post('uploadFicheiro', 'ProjetoController@uploadFicheiro')->name('uploadFicheiro');
Route::post('uploadFicheiroTarefa', 'ProjetoController@uploadFicheiroTarefa')->name('uploadFicheiroTarefa');
Route::get('delete-records','ProjetoController@index');
Route::get('delete/{id}','ProjetoController@eraseProject');
Route::post('add', 'ProjetoController@takeGrupos');

//---------------- CHAT ----------------//
Route::get('{route?}/alunomessage/{id}', 'ChatController@getMessage')->name('getmessage');
Route::get('/alunomessage/{id}', 'ChatController@getMessage')->name('getmessage');
Route::get('/getUsers', 'ChatController@getUsersView')->name('getusers');
Route::get('/getUsersDocente', 'ChatController@getUsersViewDocente')->name('getUsersDocente');
Route::post('message', 'ChatController@sendMessage');

//---------------- DOWNLOAD ----------------//
//Download
Route::get('download/{filename}', function($filename){
    // Check if file exists in app/public/disciplina/ folder
    $file_path = storage_path() .'/app/public/disciplina/'. $filename;
    if (file_exists($file_path)){
        $name = explode("_", $filename, 2)[1];
        // Send Download
        return Response::download($file_path, $name, ['Content-Length: '. filesize($file_path)]);
    }else{
        exit('Requested file does not exist on our server!');
    }
})->where('filename', '[A-Za-z0-9\-\_\.]+');

Route::get('downloadF/{filename}', function($filename){
    $file_path = storage_path().'/app/public/ficheiros_grupos/'. $filename;
    if (file_exists($file_path)){
        return Response::download($file_path, $filename,['Content-Length: '. filesize($file_path)]);
    }else{
        exit('Requested file does not exist on our server!');
    }
})->where('filename', '[A-Za-z0-9\-\_\.]+');

Route::get('downloadFT/{filename}', function($filename){
    $file_path = storage_path().'/app/public/ficheiros_tarefas/'. $filename;
    if (file_exists($file_path)){
        return Response::download($file_path, $filename, ['Content-Length: '. filesize($file_path)]);
    }else{
        exit('Requested file does not exist on our server!');
    }
})->where('filename', '[A-Za-z0-9\-\_\.]+');

//---------------- CALENDARIO ----------------//
Route::get('/projetosAluno/loadEvents/{grupo_id}', 'CalendarController@load')->name('loadEvents');
Route::post('/projetosAluno/createEvent/{title}/{start}/{end}/{allDay}/{grupo_id}', 'CalendarController@create')->name('createEvent');
Route::post('/projetosAluno/updateEvents/{id}/{title}/{start}/{end}/{allDay}', 'CalendarController@update')->name('updateEvents');
Route::post('/projetosAluno/deleteEvents/{id}', 'CalendarController@delete')->name('deleteEvents');
