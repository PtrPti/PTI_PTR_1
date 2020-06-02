<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Projeto;
use App\UserCadeira;
use App\UsersGrupos;
use App\Grupo;
use App\Http\Controllers\ChatController;
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
                                  ->where('users.id', $user->id)->select('cadeiras.nome as cadeiras', 'projetos.nome as projeto', 'grupos.numero','grupos.id','users_grupos.favorito as favorito','users_grupos.id as usersGrupos_id')->get();
            
        $grupos_ids = [];

        foreach($projetos as $g) {
            array_push($grupos_ids, $g->id);
        }
        $utilizadores = ChatController::getUsers($grupos_ids, $user->id);

        return view('aluno.alunoHome', compact('cadeiras','projetos', 'utilizadores'));
    }

    public function perfilAluno (){
        $user = Auth::user()->getUser();
        $cadeiras = UserCadeira::join('cadeiras', 'users_cadeiras.cadeira_id', '=', 'cadeiras.id')
                                  ->where('users_cadeiras.user_id', $user->id)->get();

        $projetos = User::join('users_grupos', 'users.id', '=', 'users_grupos.user_id')
                          ->join('grupos', 'users_grupos.grupo_id', '=', 'grupos.id')
                          ->join('projetos', 'grupos.projeto_id', '=', 'projetos.id')
                          ->join('cadeiras', 'projetos.cadeira_id', '=', 'cadeiras.id')
                             ->where('users.id', $user->id)->select('cadeiras.nome as cadeiras', 'projetos.nome as projeto', 'grupos.numero','grupos.id','users_grupos.favorito as favorito','users_grupos.id as usersGrupos_id')->get();

        $grupos_ids = [];

        foreach($projetos as $g) {
            array_push($grupos_ids, $g->id);
        }
        $utilizadores = ChatController::getUsers($grupos_ids, $user->id);

        return view ('aluno.perfil', compact('user','cadeiras','projetos', 'utilizadores'));
    }

    public function changeNome(Request $request){
        $user = Auth::user()->getUser();
        $novoNome = $_POST['nome'];
        User::where('id',$user->id)->update(['nome'=>$novoNome]);
        return redirect()->action('HomeController@perfilAluno');
    }

    public function changeEmail(Request $request){
        $user = Auth::user()->getUser();
        $novoEmail = $_POST['email'];
        User::where('id',$user->id)->update(['email'=>$novoEmail]);
        return redirect()->action('HomeController@perfilAluno');
    }

    public function changePass(Request $request){
        $user = Auth::user()->getUser();
        $novaPass = bcrypt($_POST['novaPass']);

        if($user->password == $atualPass){
            if($novaPass == $repNovaPass){
                User::where('id',$user->id)->update(['password'=>$novaPass]);
            }
        }

        return redirect()->action('HomeController@perfilAluno');
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

    public function pagProjeto(){
        return view('aluno.projetosAluno');
    }
    
    public function filterProj(Request $request){
        $favoritos = $request->favoritos;
        $em_curso = $request->em_curso;
        $terminados = $request->terminados;
        $user = Auth::user()->getUser();

        $query = "select c.nome as cadeiras, p.nome as projeto, g.numero, g.id, ug.favorito as favorito, ug.id as usersGrupos_id
        from users u
        inner join users_grupos ug
            on u.id = ug.user_id
        inner join grupos g
            on ug.grupo_id = g.id
        inner join projetos p
            on g.projeto_id = p.id
        inner join cadeiras c
            on p.cadeira_id = c.id
        where
            u.id = " .  $user->id;

        if($favoritos == 'true') {
            $query = $query . " and ug.favorito = 1";
        }
        if($em_curso == 'true') {
            $query = $query . " and NOW() between p.data_inicio and p.data_fim";
        }
        if($terminados == 'true') {
            $query = $query . " and p.data_fim < NOW()";
        }

        $projetos = DB::select($query);

        if($projetos == null) { 
            $data = array();
        }
        else {
            $data = array(
                'projetos'  => $projetos,
            );
        }
        
        $returnHTML = view('aluno.filtroProjeto')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
    }

    public function changeFavorito (Request $request){
        $user = Auth::user()->getUser()->id;
        $id = $_POST['usersGrupos_id'];
        $val = $_POST['val'];
        UsersGrupos::where('users_grupos.id', $id)->update(['favorito'=>$val]);
    
        return response()->json(array('html'=>'Adicionado com sucesso'));
    }
    //Docente
    public function indexDocente(){
        $user = Auth::user()->getUser();
        $disciplinas = UserCadeira::join('cadeiras', 'users_cadeiras.cadeira_id', '=', 'cadeiras.id')->where('users_cadeiras.user_id', $user->id)->get();
        $projetos = DB::select('select p.*, c.nome as cadeira, c.id as cadeira_id from projetos p
                                inner join cadeiras c
                                on p.cadeira_id = c.id
                                where p.cadeira_id in (select ca.id from users_cadeiras uc
                                inner join cadeiras ca
                                 on uc.cadeira_id = ca.id
                                 where uc.user_id = ?)', [$user->id]);        

        $cadeiras_id = [];

        foreach($disciplinas as $c) {
            array_push($cadeiras_id, $c->cadeira_id);
        }

        $utilizadores = ChatController::getUsersDocente($cadeiras_id, $user->id, $user->departamento_id);                     

        return view('docente.docenteHome', compact('disciplinas', 'projetos', 'utilizadores'));
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