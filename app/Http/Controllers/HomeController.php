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
    
    public function home(Request $request) {
        $user = Auth::user()->getUser();
        $disciplinas = UserCadeira::join('cadeiras', 'users_cadeiras.cadeira_id', '=', 'cadeiras.id')->where('users_cadeiras.user_id', $user->id)->orderBy('nome')->get();

        if($user->perfil_id == 1) { //se for aluno
            $query = "select p.id as id, p.nome as nome, c.nome as cadeira, g.id as grupo_id, g.numero as numero, ug.favorito as favorito, ug.id as usersGrupos_id
                    from projetos p
                    inner join cadeiras c
                        on p.cadeira_id = c.id
                    inner join users_cadeiras uc
                        on c.id = uc.cadeira_id and uc.user_id = ?
                    inner join grupos g
                        on p.id = g.projeto_id
                    inner join users_grupos ug
                        on g.id = ug.grupo_id and ug.user_id = ?";
            $projetos = DB::select($query, [$user->id, $user->id]);
        }
        else {
            $query = "select p.id as id, p.nome as nome, c.nome as cadeira, c.id as cadeira_id
                    from projetos p
                    inner join cadeiras c
                        on p.cadeira_id = c.id
                    inner join users_cadeiras uc
                        on c.id = uc.cadeira_id and uc.user_id = ?";
            $projetos = DB::select($query, [$user->id]);
        }

        $utilizadores = User::get();

        return view('home', compact('disciplinas', 'projetos', 'utilizadores'));
    }

    public function perfilAluno (){
        $user = Auth::user()->getUser();
        $cadeiras = UserCadeira::join('cadeiras', 'users_cadeiras.cadeira_id', '=', 'cadeiras.id')
                                  ->where('users_cadeiras.user_id', $user->id)->get();
                    
        $cadeira_ids = [];

        foreach($cadeiras as $g) {
            array_push($cadeira_ids, $g->cadeira_id);
        }

        $projetos = User::join('users_grupos', 'users.id', '=', 'users_grupos.user_id')
                          ->join('grupos', 'users_grupos.grupo_id', '=', 'grupos.id')
                          ->join('projetos', 'grupos.projeto_id', '=', 'projetos.id')
                          ->join('cadeiras', 'projetos.cadeira_id', '=', 'cadeiras.id')
                             ->where('users.id', $user->id)->select('cadeiras.nome as cadeiras', 'projetos.nome as projeto', 'grupos.numero','grupos.id','users_grupos.favorito as favorito','users_grupos.id as usersGrupos_id')->get();

        $grupos_ids = [];

        foreach($projetos as $g) {
            array_push($grupos_ids, $g->id);
        }
        $utilizadores = ChatController::getUsers($grupos_ids, $cadeira_ids, $user->id);

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
        
        $returnHTML = view('filtroProjeto')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
    }

    public function changeFavorito (Request $request){
        $user = Auth::user()->getUser()->id;
        $id = $_POST['usersGrupos_id'];
        $val = $_POST['val'];
        UsersGrupos::where('users_grupos.id', $id)->update(['favorito'=>$val]);
    
        return response()->json(array('html'=>'Adicionado com sucesso'));
    }
}