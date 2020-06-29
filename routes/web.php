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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
    
Auth::routes();
    
Route::get('/home', 'HomeController@index')->name('home');

Route::get('locale/{locale}', )->name('languages');

Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});
    
//Login
Route::get('/login', 'AuthController@getLogin')->name('login');





//Registo
Route::get('/registar', 'AuthController@getRegistar')->name('registar');
Route::post('/registar', 'AuthController@postRegistar')->name('registarPost');
Route::get('/registar/getCursos', 'AuthController@changeDepartamentoId')->name('changeDepartamentoId');
Route::get('/registar/getCadeirasAluno', 'AuthController@changeCursoId')->name('changeCursoId');
Route::get('/registar/getCadeirasProf', 'AuthController@changeDepartamentoProfId')->name('changeDepartamentoProfId');

//---------------- CHAT ----------------//
Route::get('{route?}/alunomessage/{id}', 'ChatController@getMessage')->name('getmessage');
Route::get('/alunomessage/{id}', 'ChatController@getMessage')->name('getmessage');
Route::get('/getUsers', 'ChatController@getUsersView')->name('getusers');
Route::get('/getUsersDocente', 'ChatController@getUsersViewDocente')->name('getUsersDocente');
Route::post('message', 'ChatController@sendMessage');

//---------------- DOWNLOAD ----------------//
//Download
Route::get('download/{folder}/{filename}', function($folder, $filename) {
    $file_path = storage_path() .'/app/public/' . $folder . '/'. $filename;
    if (file_exists($file_path)) {
        $name = explode("_", $filename, 2)[1];
        return Response::download($file_path, $name, ['Content-Length: '. filesize($file_path)]);
    }
    else {
        exit('Requested file does not exist on our server!');
    }
})->where('filename', '[A-Za-z0-9\-\_\.]+');

//---------------- CALENDARIO ----------------//
Route::get('/projetosAluno/loadEvents/{grupo_id}', 'CalendarController@load')->name('loadEvents');
Route::post('/projetosAluno/createEvent/{title}/{start}/{end}/{allDay}/{grupo_id}', 'CalendarController@create')->name('createEvent');
Route::post('/projetosAluno/updateEvents/{id}/{title}/{start}/{end}/{allDay}', 'CalendarController@update')->name('updateEvents');
Route::post('/projetosAluno/deleteEvents/{id}', 'CalendarController@delete')->name('deleteEvents');


//---------------- NOVO ----------------//
Route::get('/Home', 'HomeController@home')->name('home');
Route::get('/filterProj', 'HomeController@filterProj');

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

Route::post('/addAluno', 'DisciplinaController@search_aluno')->name('addAluno');
Route::get('7search_alunos', 'DisciplinaController@search_alunos')->name('search_alunos');




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

Route::get('/Home/Perfil/{tab?}', 'PerfilController@perfilDocente')->name('perfil');
Route::post('/changeNome', 'PerfilController@changeNome')->name('changeNome');
Route::post('/changeEmail', 'PerfilController@changeEmail')->name('changeEmail');
Route::post('/changePass', 'PerfilController@changePass')->name('changePass');

