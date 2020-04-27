<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Projeto;
use App\UserCadeira;
use App\UsersGrupos;
use Illuminate\Support\Facades\DB;
use Auth;
use DateTime;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('home');
    }

    //Aluno
    public function alunoHome(){
        return view('aluno.alunoHome');
    }

    public function indexAluno(){
        $user = Auth::user()->getUser();
        $disciplinas = UserCadeira::join('cadeiras', 'users_cadeiras.cadeira_id', '=', 'cadeiras.id')
                                  ->where('users_cadeiras.user_id', $user->id)->get();

        $projetos = User::join('users_grupos', 'users.id', '=', 'users_grupos.user_id')
                                  ->join('grupos', 'users_grupos.grupo_id', '=', 'grupos.id')
                                  ->join('projetos', 'grupos.projeto_id', '=', 'projetos.id')
                                  ->join('cadeiras', 'projetos.cadeira_id', '=', 'cadeiras.id')
                                      ->where('users.id', $user->id)->select('cadeiras.nome as cadeiras', 'projetos.nome as projeto', 'grupos.numero','grupos.id')->get();

        $grupos = UsersGrupos::join('grupos', 'users_grupos.grupo_id', '=', 'grupos.id')
            ->where('users_grupos.grupo_id', $user->id)->get();
    
        $utilizadores = DB::select("select users.id, users.nome, users.email, count(id_read) as unread 
            from users LEFT  JOIN  messages ON users.id = messages.from and id_read = 0 and messages.to = " . Auth::id() . "
            where users.id != " . Auth::id() . " 
            group by users.id, users.nome, users.email");

        return view('aluno.alunoHome', compact('disciplinas','projetos','grupos', 'utilizadores'));
    }

    public function pagDisciplina(int $cadeira_id){
        $user = Auth::user()->getUser();
        $cadeiras = UserCadeira::join('cadeiras', 'users_cadeiras.cadeira_id', '=', 'cadeiras.id')
                                  ->where('users_cadeiras.user_id', $user->id)->get();
        $grupos = UsersGrupos::join('grupos', 'users_grupos.grupo_id', '=', 'grupos.id')
                                  ->where('users_grupos.grupo_id', $user->id)->get();
        $cadeira = DB::table('cadeiras')->where('cadeiras.id', $cadeira_id)->get();

        return view('aluno.disciplinasAluno', compact('cadeiras','grupos','cadeira'));
    }

    public function pagProjeto(){
        return view('aluno.projetosAluno');
    }

    //Docente
    public function indexDocente($tab = "tab1"){
        $user = Auth::user()->getUser();
        $disciplinas = UserCadeira::join('cadeiras', 'users_cadeiras.cadeira_id', '=', 'cadeiras.id')->where('users_cadeiras.user_id', $user->id)->get();
        $projetos = DB::select('select * from projetos p
                                where p.cadeira_id in (select ca.id from users_cadeiras uc
                                inner join cadeiras ca
                                 on uc.cadeira_id = ca.id
                                 where uc.user_id = ?)', [$user->id]);        
        $active_tab = $tab;

        return view('docente.docenteHome', compact('disciplinas', 'projetos', 'active_tab'));
    }

    public function store(Request $request, string $redirect = ""){
        $this->validate($request, [
            'nome' => 'bail|required|string|max:255',
            'cadeira_id' => 'bail|required|int',
            'datafim' => 'bail|required|date_format:d-m-Y H:i',
            'n_elem' => 'bail|required|int',
        ]); 

        $projetos = new Projeto;

        $projetos->nome = $request->nome;
        $projetos->cadeira_id = $request->cadeira_id;
        $projetos->n_max_elementos = $request->n_elem;
        $projetos->data_fim = DateTime::createFromFormat('d-m-Y H:i', $request->datafim);

        $projetos->save();

        if ($redirect != "") {
            return redirect()->action('DisciplinaController@indexDocente', ['id' => $request->cadeira_id]);
        }

        return redirect()->action('HomeController@indexDocente', ['tab' => 'tab2']);
    }    
}
