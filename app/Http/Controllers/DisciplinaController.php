<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Grupo;
use App\Projeto;
use App\Cadeira;
<<<<<<< HEAD
use App\UserCadeira;
use App\UsersGrupos;
=======
use App\ProjetoFicheiro;
>>>>>>> 9177a3fcedf88aa481acb5ca7101508295fc0fc4
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Auth;
use DateTime;

class DisciplinaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

<<<<<<< HEAD
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    //Aluno
    public function showProjetos(int $cadeira_id, int $projeto_id){
        $grupos = Grupo::where('grupos.projeto_id', $projeto_id);
        return view('aluno.disciplinasAluno', compact('grupos'));
    }

    public function pagDisciplina(int $cadeira_id){
        //Navbar
        $user = Auth::user()->getUser();
        $disciplinas = UserCadeira::join('cadeiras', 'users_cadeiras.cadeira_id', '=', 'cadeiras.id')
                                  ->where('users_cadeiras.user_id', $user->id)->get();
        $projetos = UsersGrupos::join('grupos', 'users_grupos.grupo_id', '=', 'grupos.id')
                                  ->where('users_grupos.grupo_id', $user->id)->get();

        //Inf da cadeira
        $cadeira = Cadeira::where('cadeiras.id', $cadeira_id)->get();
        $cadeiraProjetos = Projeto::where('projetos.cadeira_id', $cadeira_id)->get();
        
        return view('aluno.disciplinasAluno', compact('disciplinas','projetos','cadeira','cadeiraProjetos'));
    }

    //Docente
    public function indexDocente(int $id){
        $projetos = Projeto::where('cadeira_id', $id)->get();
=======
    public function indexDocente(int $id)
    {
        $projetos = DB::select('select p.id, p.nome, p.data_fim, pf.nome as ficheiro 
                                from projetos p
                                left join projetos_ficheiros pf
                                    on p.id = pf.projeto_id
                                where p.cadeira_id = ?', [$id]);
                                // error_log( print_r($projetos, TRUE) );
>>>>>>> 9177a3fcedf88aa481acb5ca7101508295fc0fc4
        $cadeira = Cadeira::where('id', $id)->first();
        return view('disciplina.indexDocente', compact('projetos', 'cadeira'));
    }

    public function showGrupos(Request $request) {
        $id = $_GET['id'];
        $grupos = Grupo::where('projeto_id', $id)->get();
        $projeto = Projeto::where('id', $id)->first();

        $data = array(
            'grupos'  => $grupos,
            'projeto' => $id,
            'max_elementos' => $projeto->n_max_elementos
        );

        $returnHTML = view('disciplina.grupos')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
    }

    public function addGrupo(Request $request) {
        $id = $_GET['id'];
        $numero = Grupo::where('projeto_id', $id)->max('numero');
        $projeto = Projeto::where('id', $id)->first();
        
        $grupo = new Grupo;
        $grupo->projeto_id = $id;
        $grupo->numero = ($numero == null ? 1 : $numero + 1);
        $grupo->save();

        return response()->json(['numero' => ($numero == null ? 1 : $numero + 1), 'max_elem' => $projeto->n_max_elementos]);
    }

    function uploadFile(Request $request) {
        if (Input::hasFile('file')) {
            $filename = $request->projeto_id . '_' . $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('public/disciplina', $filename);

            $ficheiro = new ProjetoFicheiro();
            $ficheiro->nome = $filename;
            $ficheiro->projeto_id = $request->projeto_id;
            $ficheiro->save();
        }

        return redirect()->action('DisciplinaController@indexDocente', ['id' => $request->cadeira_id]);
    }
}
