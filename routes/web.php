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
Route::get('/projetosAluno/{id}/{tarefa_id?}', 'ProjetoController@pagProjeto')->name('pagProjeto');

//Disciplinas
Route::get('/docenteHome/disciplina/{id}', 'DisciplinaController@indexDocente')->name('indexDisciplinaDocente');
Route::get('addGrupo', 'DisciplinaController@addGrupo');
Route::get('showGrupos', 'DisciplinaController@showGrupos');
Route::post('uploadFile', 'DisciplinaController@uploadFile')->name('uploadFile');

//Projetos
Route::get('projetos', 'ProjetoController@nome_projetos')->name('projeto');
Route::get('projetos/{id}', 'ProjetoController@id_projetos')->name('id_projeto');
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
Route::get('addSubmissao', 'ProjetoController@addSubmissao');
Route::get('addNota', 'ProjetoController@addNota');
Route::get('addTarefa', 'ProjetoController@addTarefa');
Route::get('subTarefas', 'ProjetoController@subTarefas');
Route::get('addSubTarefa', 'ProjetoController@addSubTarefa');
Route::get('pesquisar', 'ProjetoController@pesquisar');
Route::post('uploadFicheiro', 'ProjetoController@uploadFicheiro')->name('uploadFicheiro');
Route::post('uploadFicheiroTarefa', 'ProjetoController@uploadFicheiroTarefa')->name('uploadFicheiroTarefa');
Route::get('delete-records','ProjetoController@index');
Route::get('delete/{id}','ProjetoController@eraseProject');

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
