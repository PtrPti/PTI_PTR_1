<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Projeto;
use App\UserCadeira;
use App\UsersGrupos;
use App\Grupo;
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
    public function index() {
        return view('welcome');
    }

    //Aluno
    public function alunoHome() {
        return view('aluno.alunoHome');
    }

    public function indexAluno() {
        $user = Auth::user()->getUser();
        $cadeiras = UserCadeira::join('cadeiras', 'users_cadeiras.cadeira_id', '=', 'cadeiras.id')
                                  ->where('users_cadeiras.user_id', $user->id)->get();

        $projetos = User::join('users_grupos', 'users.id', '=', 'users_grupos.user_id')
                                  ->join('grupos', 'users_grupos.grupo_id', '=', 'grupos.id')
                                  ->join('projetos', 'grupos.projeto_id', '=', 'projetos.id')
                                  ->join('cadeiras', 'projetos.cadeira_id', '=', 'cadeiras.id')
                                      ->where('users.id', $user->id)->select('cadeiras.nome as cadeiras', 'projetos.nome as projeto', 'grupos.numero','grupos.id')->get();
            
        $grupos_ids = [];

        foreach($projetos as $g) {
            array_push($grupos_ids, $g->id);
        }

        DB::statement(DB::raw('set @row_number=0'));
        $utilizadores = DB::select(DB::raw(
            "select 
                (@row_number:=@row_number + 1) AS row,
                u.id,
                u.nome,
                u.email,
                count(m.id_read) as unread,
                m2.message as last_message,
                m2.created_at as lm_date
            from users u
            inner join users_grupos ug
                on u.id = ug.user_id
                and ug.grupo_id in (:grupos)
            left join  messages m
                on u.id = m.from 
                and id_read = 0 
                and m.to = :u1
            inner join (select * from messages order by created_at desc) as m2
                on (m2.from = :u2 and m2.to = u.id)
                or (m2.to = :u3 and m2.from = u.id)
            where u.id != :u4
            group by u.id, u.nome, u.email")
                    , ['grupos' => implode("','", $grupos_ids), 'u1' => $user->id, 'u2' => $user->id, 'u3' => $user->id, 'u4' => $user->id]
        );

        return view('aluno.alunoHome', compact('cadeiras','projetos', 'utilizadores'));
    }

    public function pagDisciplina(int $cadeira_id){
        $user = Auth::user()->getUser();
        $cadeiras = UserCadeira::join('cadeiras', 'users_cadeiras.cadeira_id', '=', 'cadeiras.id')
                                  ->where('users_cadeiras.user_id', $user->id)->get();
        $grupos = UsersGrupos::join('grupos', 'users_grupos.grupo_id', '=', 'grupos.id')
                                  ->where('users_grupos.user_id', $user->id)->get();
        $cadeira = DB::table('cadeiras')->where('cadeiras.id', $cadeira_id)->get();

        return view('aluno.disciplinasAluno', compact('cadeiras','grupos','cadeira'));
    }

    //Docente
    public function indexDocente(){
        $user = Auth::user()->getUser();
        $disciplinas = UserCadeira::join('cadeiras', 'users_cadeiras.cadeira_id', '=', 'cadeiras.id')->where('users_cadeiras.user_id', $user->id)->get();
        $projetos = DB::select('select p.*, c.nome as "cadeira" from projetos p
                                inner join cadeiras c
                                on p.cadeira_id = c.id
                                where p.cadeira_id in (select ca.id from users_cadeiras uc
                                inner join cadeiras ca
                                 on uc.cadeira_id = ca.id
                                 where uc.user_id = ?)', [$user->id]);

        return view('docente.docenteHome', compact('disciplinas', 'projetos'));
    }

    public function store(Request $request, string $redirect = ""){
        $this->validate($request, [
            'nome' => 'bail|required|string|max:255',
            'cadeira_id' => 'bail|required|int',
            'datainicio' => 'bail|required|date_format:d-m-Y H:i',
            'datafim' => 'bail|date_format:d-m-Y H:i',
            'n_elem' => 'bail|required|int',
        ]); 

        $projetos = new Projeto;

        $projetos->nome = $request->nome;
        $projetos->cadeira_id = $request->cadeira_id;
        $projetos->n_max_elementos = $request->n_elem;
        $projetos->estado = "";
        $projetos->inscricoes = true;
        $projetos->data_inicio = DateTime::createFromFormat('d-m-Y H:i', $request->datainicio);
        $projetos->data_fim = DateTime::createFromFormat('d-m-Y H:i', $request->datafim);

        $projetos->save();

        return redirect()->action('HomeController@indexDocente');
    }    
}