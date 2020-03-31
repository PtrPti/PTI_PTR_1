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

//Registo
Route::get('/registar', 'AuthController@getRegistar')->name('registar');
Route::post('/registar', 'AuthController@postRegistar')->name('registarPost');
Route::get('/registar/getCursos', 'AuthController@changeDepartamentoId')->name('changeDepartamentoId');
Route::get('/registar/getCadeirasAluno', 'AuthController@changeCursoId')->name('changeCursoId');
Route::get('/registar/getCadeirasProf', 'AuthController@changeDepartamentoProfId')->name('changeDepartamentoProfId');

//Login
//Route::get('register', function(){ return view('alunoHome');});

//Alunos
Route::get('/alunoHome/{tab?}', 'HomeController@indexAluno')->name('homeAluno');
Route::get('/disciplinasAluno/{cadeira_id}', 'HomeController@pagDisciplina')->name('pagDisciplina'); 
//Route::get('/docenteHome/disciplina/{id}', 'DisciplinaController@indexDocente')->name('indexDisciplinaDocente');
Route::get('/projetosAluno', 'HomeController@pagProjeto')->name('pagProjeto');  

//Docentes
Route::get('/docenteHome/{tab?}', 'HomeController@indexDocente')->name('homeDocente');
Route::post('/docenteHome', 'HomeController@store')->name('projetoPost');
Route::get('/docenteHome', 'HomeController@perfil')->name('perfil');
