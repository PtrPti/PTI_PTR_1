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

//Registo
Route::get('/registar', 'AuthController@getRegistar')->name('registar');
Route::post('/registar', 'AuthController@postRegistar')->name('registarPost');
Route::get('/registar/getCursos', 'AuthController@changeDepartamentoId')->name('changeDepartamentoId');
Route::get('/registar/getCadeirasAluno', 'AuthController@changeCursoId')->name('changeCursoId');
Route::get('/registar/getCadeirasProf', 'AuthController@changeDepartamentoProfId')->name('changeDepartamentoProfId');

//Docentes
Route::get('/docenteHome/{tab?}', 'HomeController@indexDocente')->name('homeDocente');
Route::post('/docenteHome/{redirect?}', 'HomeController@store')->name('projetoPost');
Route::get('/docenteHome', 'HomeController@perfil')->name('perfil');

//Alunos
Route::get('/alunoHome/{tab?}', 'HomeController@indexAluno')->name('homeAluno');
Route::get('/disciplinasAluno/{cadeira_id}', 'HomeController@pagDisciplina')->name('pagDisciplina');
Route::get('/projetosAluno', 'HomeController@pagProjeto')->name('pagProjeto');  

//Disciplinas
Route::get('/docenteHome/disciplina/{id}', 'DisciplinaController@indexDocente')->name('indexDisciplinaDocente');
Route::get('addGrupo', 'DisciplinaController@addGrupo');
Route::get('showGrupos', 'DisciplinaController@showGrupos');

//Projetos
Route::get('projetos', 'HomeController@nome_projetos')->name('projeto');
Route::get('projetos/{id}', 'HomeController@id_projetos')->name('id_projeto');

//---------------- ALUNOS ----------------//
//Home
Route::get('/alunoHome/{tab?}', 'HomeController@indexAluno')->name('homeAluno');
Route::get('/alunoHome', 'HomeController@alunoHome')->name('alunoHome');
  
//Disciplina
Route::get('/disciplinasAluno/{cadeira_id}', 'DisciplinaController@pagDisciplina')->name('pagDisciplina');
Route::get('showGruposA', 'DisciplinaController@showGruposA');
Route::get('verMensagens', 'DisciplinaController@verMensagens');
Route::post('/addTopico', 'DisciplinaController@addTopico');
Route::post('/addMensagem', 'DisciplinaController@addMensagem');

//Projeto
Route::get('/projetosAluno', 'HomeController@pagProjeto')->name('pagProjeto');
Route::get('editTarefa', 'ProjetoController@editTarefa');
Route::get('editAllTarefa', 'ProjetoController@editAllTarefa');
Route::get('addLink', 'ProjetoController@addLink');
Route::get('addPasta', 'ProjetoController@addPasta');
Route::post('uploadFicheiro', 'ProjetoController@uploadFicheiro')->name('uploadFicheiro');

//Messages
Route::get('/alunomessage/{id}', 'ChatController@getMessage')->name('getmessage');
Route::post('message', 'ChatController@sendMessage');
Route::get('delete-records','ProjetoController@index');
Route::get('delete/{id}','ProjetoController@eraiseProject');

