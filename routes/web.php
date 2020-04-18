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

//Login
Route::get('/login', 'AuthController@getLogin')->name('login');

//Registo
Route::get('/registar', 'AuthController@getRegistar')->name('registar');
Route::post('/registar', 'AuthController@postRegistar')->name('registarPost');
Route::get('/registar/getCursos', 'AuthController@changeDepartamentoId')->name('changeDepartamentoId');
Route::get('/registar/getCadeirasAluno', 'AuthController@changeCursoId')->name('changeCursoId');
Route::get('/registar/getCadeirasProf', 'AuthController@changeDepartamentoProfId')->name('changeDepartamentoProfId');

//Docentes
Route::get('/docenteHome/{tab?}', 'HomeController@indexDocente')->name('homeDocente')->middleware('checkUserRole:2');
Route::post('/docenteHome/{redirect?}', 'HomeController@store')->name('projetoPost')->middleware('checkUserRole:2');
Route::get('/docenteHome', 'HomeController@perfil')->name('perfil')->middleware('checkUserRole:2');

//Alunos
Route::get('/alunoHome/{tab?}', 'HomeController@indexAluno')->name('homeAluno')->middleware('checkUserRole:1');
Route::get('/disciplinasAluno/{cadeira_id}', 'HomeController@pagDisciplina')->name('pagDisciplina')->middleware('checkUserRole:1');
Route::get('/projetosAluno', 'HomeController@pagProjeto')->name('pagProjeto')->middleware('checkUserRole:1');

//Disciplinas
Route::get('/docenteHome/disciplina/{id}', 'DisciplinaController@indexDocente')->name('indexDisciplinaDocente');
Route::get('addGrupo', 'DisciplinaController@addGrupo');
Route::get('showGrupos', 'DisciplinaController@showGrupos');
Route::post('uploadFile', 'DisciplinaController@uploadFile')->name('uploadFile');

//Projetos
Route::get('projetos', 'ProjetoController@nome_projetos')->name('projeto');
Route::get('projetos/{id}', 'ProjetoController@id_projetos')->name('id_projeto');
Route::get('delete-records','ProjetoController@index');
Route::get('delete/{id}','ProjetoController@eraseProject');

//Download
Route::get('download/{filename}', function($filename)
{
    // Check if file exists in app/public/disciplina/ folder
    $file_path = storage_path() .'/app/public/disciplina/'. $filename;
    if (file_exists($file_path))
    {
        $name = explode("_", $filename, 2)[1];
        error_log($name);
        // Send Download
        return Response::download($file_path, $name, 
        [
            'Content-Length: '. filesize($file_path)
        ]);
    }
    else
    {
        // Error
        exit('Requested file does not exist on our server!');
    }
})
->where('filename', '[A-Za-z0-9\-\_\.]+');
