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

//---------------- ADMINISTRAÇÃO ----------------//
Route::get('/admin', function () {
    return view('administrador');
});

// Route::get('/adminHome', function() {
//     return view('administrador.adminHome');
// });

//Login
//Route::get('/loginAdmin', 'AdminController@getLogin')->name('login');

//Home
Route::get('/adminHome', 'HomeController@indexAdmin')->name('homeAluno');
Route::get('/showDB', 'HomeController@showBD');
//---------------- DOCENTES ----------------//
//Home
Route::get('/docenteHome/{tab?}', 'HomeController@indexDocente')->name('homeDocente');
Route::post('/docenteHome/{redirect?}', 'HomeController@store')->name('projetoPost');
Route::get('/docenteHome', 'HomeController@perfil')->name('perfil');

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

//---------------- ALUNOS ----------------//
//Home
Route::get('/alunoHome/{tab?}', 'HomeController@indexAluno')->name('homeAluno');
Route::get('/alunoHome', 'HomeController@alunoHome')->name('alunoHome');
Route::post('/filterProj', 'HomeController@filterProj');
Route::post('/changeFavorito', 'HomeController@changeFavorito');

//Disciplina
Route::get('/disciplinasAluno/{cadeira_id}', 'DisciplinaController@pagDisciplina')->name('pagDisciplina');
Route::get('showGruposA', 'DisciplinaController@showGruposA');
Route::get('verMensagens', 'DisciplinaController@verMensagens');
Route::get('showForum', 'DisciplinaController@showForum');
Route::post('/addTopico', 'DisciplinaController@addTopico');
Route::post('/addMensagem', 'DisciplinaController@addMensagem');
Route::post('/removeUser', 'DisciplinaController@removeUser');
Route::post('/addUser', 'DisciplinaController@addUser');
Route::post('/addGroup', 'DisciplinaController@addGroup');
Route::post('/addUserGroup', 'DisciplinaController@addUserGroup');
Route::get('forum', 'DisciplinaController@Forum');

// Route::get('showGrup', 'DisciplinaController@showGrup');

//Projeto
Route::get('/projetosAluno/{id}', 'ProjetoController@pagProjeto')->name('pagProjeto');
Route::get('editTarefa', 'ProjetoController@editTarefa');
Route::get('editAllTarefa', 'ProjetoController@editAllTarefa');
Route::get('addLink', 'ProjetoController@addLink');
Route::get('addPasta', 'ProjetoController@addPasta');
Route::get('addTarefa', 'ProjetoController@addTarefa');
Route::get('subTarefas', 'ProjetoController@subTarefas');
Route::get('addSubTarefa', 'ProjetoController@addSubTarefa');
Route::post('uploadFicheiro', 'ProjetoController@uploadFicheiro')->name('uploadFicheiro');

//Messages
Route::get('/alunomessage/{id}', 'ChatController@getMessage')->name('getmessage');
Route::post('message', 'ChatController@sendMessage');

//---------------- DOWNLOAD ----------------//
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

Route::get('downloadF/{filename}', function($filename){
    $file_path = storage_path().'/app/public/ficheiros_grupos/'. $filename;
    if (file_exists($file_path)){
        return Response::download($file_path, $filename, 
        ['Content-Length: '. filesize($file_path)]);
    }else{
        exit('Requested file does not exist on our server!');
    }
})->where('filename', '[A-Za-z0-9\-\_\.]+');