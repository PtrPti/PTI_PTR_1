<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Grupo;
use App\Projeto;
use App\Cadeira;
use App\UserCadeira;
use App\UsersGrupos;
use App\ProjetoFicheiro;
use App\ForumDuvidas;
use App\ForumMensagens;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Auth;
use DateTime;
use Session;
use Validator;

class DisciplinaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    //Aluno
    public function pagDisciplina(int $cadeira_id){
        //Navbar
        $user = Auth::user()->getUser();
        $disciplinas = UserCadeira::join('cadeiras', 'users_cadeiras.cadeira_id', '=', 'cadeiras.id')
                          ->where('users_cadeiras.user_id', $user->id)->get();
        $projetos = User::join('users_grupos', 'users.id', '=', 'users_grupos.user_id')
                          ->join('grupos', 'users_grupos.grupo_id', '=', 'grupos.id')
                          ->join('projetos', 'grupos.projeto_id', '=', 'projetos.id')
                          ->join('cadeiras', 'projetos.cadeira_id', '=', 'cadeiras.id')
                             ->where('users.id', $user->id)->select('cadeiras.nome as cadeiras', 'projetos.nome as projeto', 'grupos.numero','grupos.id','users_grupos.favorito as favorito','users_grupos.id as usersGrupos_id')->get();

        //Inf da cadeira
        $cadeira = Cadeira::where('cadeiras.id', $cadeira_id)->get();
        $cadeiraProjetos = Projeto::where('projetos.cadeira_id', $cadeira_id)->get();
        $docentes = User::join('users_cadeiras', 'users.id', '=', 'users_cadeiras.user_id')
                          ->where('users.perfil_id', 2)
                          ->where('users_cadeiras.cadeira_id', $cadeira_id)->get();
        $duvidas = ForumDuvidas::where('forum_duvidas.cadeira_id', $cadeira_id)->get();
        $mensagens = ForumMensagens::join('forum_duvidas', 'forum_duvida_id', '=', 'forum_duvidas.id')->get();
        // $totalMensagens = $mensagens->count();

        $cadeiras = UserCadeira::join('cadeiras', 'users_cadeiras.cadeira_id', '=', 'cadeiras.id')
                                  ->where('users_cadeiras.user_id', $user->id)->get();

        $grupos_ids = [];

        foreach($projetos as $g) {
            array_push($grupos_ids, $g->id);
        }
        $utilizadores = ChatController::getUsers($grupos_ids, $user->id);
                                
        return view('aluno.disciplinasAluno', compact('user','disciplinas','projetos','cadeira','cadeiraProjetos','docentes','duvidas','mensagens', 'cadeiras', 'utilizadores'));
    }

    public function showForum(Request $request){
        $cadeira_id = $_GET['cadeira_id'];
        $cadeira = Cadeira::where('cadeiras.id', $cadeira_id)->get();
        $duvidas = DB::select('select fd.*, u1.nome as "primeiro", u2.nome as "ultimo"
                                from forum_duvidas fd
                                inner join users u1
                                on fd.primeiro_user = u1.id
                                inner join users u2
                                on fd.ultimo_user = u2.id
                                where fd.cadeira_id = (?)', [$cadeira_id]);

        $data = array(
            'cadeira'  => $cadeira,
            'duvidas' => $duvidas,
        );

        $returnHTML = view('aluno.forum')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
    }

    public function Forum (Request $request){
        $cadeira_id = $request->cadeira_id;
        $cadeira = Cadeira::where('cadeiras.id', $cadeira_id)->get();
        $duvidas = ForumDuvidas::where('forum_duvidas.cadeira_id', $cadeira_id)->get();
        return view('aluno.forum', compact('cadeira','duvidas'));
    }

    public function addTopico(Request $request){
        $user = Auth::user()->getUser()->id;
        $assunto = $_POST['assunto'];
        $mensagem = $_POST['mensagem'];
        $cadeira_id = $_POST['cadeira_id'];

        $novoTopico = new ForumDuvidas;
        $novoTopico->assunto = $assunto;
        $novoTopico->primeiro_user = $user;
        $novoTopico->ultimo_user = $user;
        $novoTopico->cadeira_id = $cadeira_id;
        $novoTopico->save();

        $novaMensagem = new ForumMensagens;
        $novaMensagem->forum_duvida_id = $novoTopico->id;
        $novaMensagem->user_id = $user;
        $novaMensagem->mensagem = $mensagem;
        $novaMensagem->save();
    
        // return redirect()->action('DisciplinaController@Forum', ['cadeira_id' => $request->cadeira_id]);
    }

    public function verMensagens(Request $request) {
        $id = $_GET['id'];
        $mensagens = ForumMensagens::where('forum_duvida_id', $id)->get();
        $duvida = ForumDuvidas::where('id', $id)->get();

        $data = array(
            'mensagens'  => $mensagens,
            'duvida' => $duvida,
        );

        $returnHTML = view('aluno.mensagens')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
    }

    public function addMensagem(Request $request){
        $user = Auth::user()->getUser()->id;

        ForumDuvidas::update(['ultimo_user'=>$user]);

        $novaMensagem = new ForumMensagens;
        $novaMensagem->forum_duvida_id = $request->duvida_id;
        $novaMensagem->user_id = $user;
        $novaMensagem->mensagem = $request->mensagem;
        $novaMensagem->save();
    
        return redirect()->action('DisciplinaController@pagDisciplina', ['cadeira_id' => $request->cadeira_id]);
    }

    public function showGruposA(Request $request) {
        $id = $_GET['id'];
        $user = Auth::user()->getUser()->id;
        $projeto = Projeto::where('id', $id)->first();
        $grupos = DB::select("select g.id, g.numero, count(ug.user_id) as 'total_membros', IFNULL(group_concat(u.nome), '-') as 'elementos' from grupos g
                                left join users_grupos ug
                                    on g.id = ug.grupo_id
                                left join users u
                                    on ug.user_id = u.id
                                where g.projeto_id = (?)
                                group by
                                    g.id, g.numero, 'total_membros', 'elementos'", [$id]);
        $pertenceGrupo = UsersGrupos::join('grupos', 'users_grupos.grupo_id', '=', 'grupos.id')
                                    ->where('grupos.projeto_id', $id)
                                    ->where('users_grupos.user_id', $user)->first();
        
        $data = array(
            'user'          => $user,
            'projeto'       => $projeto,
            'grupos'        => $grupos,           
            'pertenceGrupo' => $pertenceGrupo
        );

        $returnHTML = view('aluno.grupos')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
    }

    public function removeUser(Request $request) {
        $user = Auth::user()->getUser()->id;
        $grupo_id = $_POST['grupo_id'];
        UsersGrupos::where([
            ['user_id', '=', $user],
            ['grupo_id', '=', $grupo_id],
        ])->delete();
        return response()->json(array('html'=>'Removido com sucesso'));
    }

    public function addUser(Request $request) {
        $user = Auth::user()->getUser()->id;
        $grupo_id = $_POST['grupo_id'];
        UsersGrupos::insert(["user_id" => $user, "grupo_id" => $grupo_id]);
        return response()->json(array('html'=>'User adicionado com sucesso'));
    }

    public function addGroup(Request $request) {
        $projeto_id = $_POST['projeto_id'];
        $numero = Grupo::where('projeto_id', $projeto_id)->max('numero');

        $novoGrupo = new Grupo;
        $novoGrupo->numero = ($numero == null ? 1 : $numero + 1);
        $novoGrupo->projeto_id = $projeto_id;
        $novoGrupo->save();

        return response()->json(array('html'=>'Grupo adicionado com sucesso'));
    }

    public function addUserGroup(Request $request) {
        $user = Auth::user()->getUser()->id;
        $projeto_id = $_POST['projeto_id'];
        $numero = Grupo::where('projeto_id', $projeto_id)->max('numero');

        $novoGrupo = new Grupo;
        $novoGrupo->numero = ($numero == null ? 1 : $numero + 1);
        $novoGrupo->projeto_id = $projeto_id;
        $novoGrupo->save();

        $novoUserGroupo = new UsersGrupos;
        $novoUserGroupo->user_id = $user;
        $novoUserGroupo->grupo_id = $novoGrupo->id;
        $novoUserGroupo->save();

        return response()->json(array('html'=>'Grupo e user adicionados com sucesso'));
    }

    //Docente
    public function indexDocente(Request $request, int $id, $tab = "tab1") {            
        $user = Auth::user()->getUser();                    
        $disciplinas = UserCadeira::join('cadeiras', 'users_cadeiras.cadeira_id', '=', 'cadeiras.id')->where('users_cadeiras.user_id', $user->id)->get();
        $projetos = DB::select('select p.*, c.nome as cadeira, pf.nome as ficheiro 
                                from projetos p
                                left join projetos_ficheiros pf
                                    on p.id = pf.projeto_id
                                inner join cadeiras c
                                    on p.cadeira_id = c.id
                                where p.cadeira_id in (select ca.id from users_cadeiras uc
                                        inner join cadeiras ca
                                            on uc.cadeira_id = ca.id
                                        where uc.user_id = ?)', [$user->id]);
        
        $projetos_cadeira = DB::select('select p.*, c.nome as cadeira, pf.nome as ficheiro 
                                        from projetos p
                                        left join projetos_ficheiros pf
                                            on p.id = pf.projeto_id
                                        inner join cadeiras c
                                            on p.cadeira_id = c.id
                                        where p.cadeira_id = ?', [$id]);

        $cadeira = Cadeira::where('id', $id)->first();
        $docentes = User::join('users_cadeiras', 'users.id', '=', 'users_cadeiras.user_id')
                          ->where('users.perfil_id', 2)
                          ->where('users_cadeiras.cadeira_id', $cadeira->id)->get();
        $active_tab = $tab;
        
        $funcParams = [];
        $openForm = "";
        $errors = Session::get('errors');

        if(Session::has('func')){
            $funcParams = Session::get('func');

            if($errors != null) {
                if($errors->any()) {
                    $request->session()->keep(['errors']);
                    if ($funcParams[2] == "forum") {
                        $openForm = "#add_button";
                    }
                    elseif ($funcParams[2] == "forumMensagens") {
                        $openForm = "#add_mensagem_" . $funcParams[3];
                    }
                }
            }
        }

        $cadeiras_id = [];

        foreach($disciplinas as $c) {
            array_push($cadeiras_id, $c->cadeira_id);
        }

        $utilizadores = ChatController::getUsersDocente($cadeiras_id, $user->id, $user->departamento_id);     

        return view('disciplina.indexDocente', compact('projetos', 'projetos_cadeira', 'disciplinas', 'cadeira', 'docentes', 'utilizadores', 'active_tab', 'funcParams', 'openForm'));
    }

    public function showGrupos(Request $request) {
        $id = $_GET['id'];
        // $grupos = Grupo::where('projeto_id', $id)->get();
        $projeto = Projeto::where('id', $id)->first();

        $grupos = DB::select("select g.id, g.numero, count(ug.user_id) as 'total_membros', IFNULL(group_concat(u.nome), '-') as 'elementos' from grupos g
                                left join users_grupos ug
                                    on g.id = ug.grupo_id
                                left join users u
                                    on ug.user_id = u.id
                                where g.projeto_id = (?)
                                group by
                                    g.id, g.numero, 'total_membros', 'elementos'", [$id]);

        $data = array(
            'grupos'  => $grupos,
            'projeto_id' => $id,
            'max_elementos' => $projeto->n_max_elementos
        );

        $returnHTML = view('disciplina.grupos')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
    }

    public function addGrupo(Request $request) {
        $id = $_GET['id'];
        $n_grupos = $_GET['grupos'];

        $numero = Grupo::where('projeto_id', $id)->max('numero');
        $numero = $numero == null ? 1 : $numero;

        $projeto = Projeto::where('id', $id)->first();

        $data = array();
        
        for ($i = 1; $i <= $n_grupos; $i++, $numero++) {
            $grupo = new Grupo;
            $grupo->projeto_id = $id;
            $grupo->numero = $numero + 1;
            $grupo->save();

            array_push($data, [$numero + 1, $projeto->n_max_elementos, $grupo->id]);
        }

        return response()->json($data);
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

    public function getPagInicial(Request $request) {
        $cadeira_id = $_GET["id"];

        $cadeira = Cadeira::where('id', $cadeira_id)->first();
        $docentes = User::join('users_cadeiras', 'users.id', '=', 'users_cadeiras.user_id')
                          ->where('users.perfil_id', 2)
                          ->where('users_cadeiras.cadeira_id', $cadeira_id)->get();

        $data = array(
            'cadeira' => $cadeira,
            'docentes' => $docentes
        );                

        $returnHTML = view('disciplina.pagInicial')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
    }

    public function getForum(Request $request) {
        $cadeira_id = $_GET['id'];
        $duvidas = DB::select('select fd.*, u1.nome as "primeiro", u2.nome as "ultimo", count(fm.id) as "totalMensagens"
                            from forum_duvidas fd
                            inner join users u1
                                on fd.primeiro_user = u1.id
                            inner join users u2
                                on fd.ultimo_user = u2.id
                            inner join forum_mensagens fm
                                on fd.id = fm.forum_duvida_id
                            where fd.cadeira_id = (?)
                            group by fd.id', [$cadeira_id]);

        $data = array(
            'cadeira_id'  => $cadeira_id,
            'duvidas' => $duvidas,

        );

        $returnHTML = view('disciplina.forum')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
    }    

    public function verMensagensDocente(Request $request) {
        $id = $_GET['id'];

        $mensagens = DB::select('select fm.*, u.nome from forum_mensagens fm
                                inner join users u
                                on fm.user_id = u.id
                                where forum_duvida_id = (?) 
                                order by bloco asc, created_at asc', [$id]);

        $duvida = ForumDuvidas::where('id', $id)->first();

        $data = array(
            'mensagens'  => $mensagens,
            'duvida' => $duvida,
        );

        $returnHTML = view('disciplina.forumMensagens')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
    }

    public function addTopicoDocente(Request $request){
        Session::flash('func', [$request->cadeira_id, '/getForum', 'forum']);

        $this->validate($request, [
            'assunto' => 'bail|required|string',
            'mensagem' => 'bail|required|string',
        ]);

        $user = Auth::user()->getUser();

        $novoTopico = new ForumDuvidas;
        $novoTopico->assunto = $request->assunto;
        $novoTopico->primeiro_user = $user->id;
        $novoTopico->ultimo_user = $user->id;
        $novoTopico->cadeira_id = $request->cadeira_id;
        $novoTopico->save();

        $novaMensagem = new ForumMensagens;
        $novaMensagem->forum_duvida_id = $novoTopico->id;
        $novaMensagem->user_id = $user->id;
        $novaMensagem->mensagem = $request->mensagem;
        $novaMensagem->bloco = 0;
        $novaMensagem->save();
    
        return redirect()->action('DisciplinaController@indexDocente', ['id' => $request->cadeira_id]);
    }

    public function replyForum(Request $request) {
        Session::flash('func', [$request->duvida_id, '/verMensagensDocente', 'forumMensagens', $request->mensagem_id]);

        $this->validate($request, [
            'mensagem' => 'bail|required|string|max:4000',
        ]);

        $user = Auth::user()->getUser();

        $bloco = DB::select('select max(bloco) as "bloco" from forum_mensagens where forum_duvida_id = (?) and resposta_a = (?)', [$request->duvida_id, $request->mensagem_id]);

        $resposta = new ForumMensagens();
        $resposta->mensagem = $request->mensagem;
        $resposta->resposta_a = $request->mensagem_id;
        $resposta->forum_duvida_id = $request->duvida_id;
        $resposta->user_id = $user->id;
        
        if ($bloco[0]->bloco == null) { //criar um novo nivel -> neste caso é a primeira resposta de todas ou uma respota a outra resposta
            $bloco_pai = DB::select('select bloco from forum_mensagens where forum_duvida_id = (?) and id = (?)', [$request->duvida_id, $request->mensagem_id]); //vai buscar o bloco do pai/nivel superior
            if ($bloco_pai[0]->bloco == 0) { //resposta ao mensagem de cricao do topico (1a mensagem de todas)
                $resposta->bloco = $bloco_pai[0]->bloco + 1;
            }
            else { //resposta a outra resposta já existente (sem ser a principal/pai)
                $resposta->bloco = $bloco_pai[0]->bloco;
            }
        }
        else { //neste caso repsonde-se à mensagem inicial, mas não é a primeira reposta à msg inicial
            $resposta->bloco = $bloco[0]->bloco + 1;
        }

        $resposta->save();

        $forum = ForumDuvidas::find($request->duvida_id);
        $forum->ultimo_user = $user->id;
        $forum->save();

        return redirect()->action('DisciplinaController@indexDocente', ['id' => $request->cadeira_id]);
    }
}
