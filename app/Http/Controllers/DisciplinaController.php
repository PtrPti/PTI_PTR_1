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
        $projetos = UsersGrupos::join('grupos', 'users_grupos.grupo_id', '=', 'grupos.id')
                          ->where('users_grupos.grupo_id', $user->id)->get();

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

        $utilizadores = DB::select("select users.id, users.nome, users.email, count(id_read) as unread 
                                    from users LEFT  JOIN  messages ON users.id = messages.from and id_read = 0 and messages.to = " . Auth::id() . "
                                    where users.id != " . Auth::id() . " 
                                    group by users.id, users.nome, users.email");
                                
        return view('aluno.disciplinasAluno', compact('user','disciplinas','projetos','cadeira','cadeiraProjetos','docentes','duvidas','mensagens', 'cadeiras', 'utilizadores'));
    }

    public function addTopico(Request $request){
        $user = Auth::user()->getUser()->id;

        $novoTopico = new ForumDuvidas;
        $novoTopico->assunto = $request->assunto;
        $novoTopico->primeiro_user = $user;
        $novoTopico->ultimo_user = $user;
        $novoTopico->cadeira_id = $request->cadeira_id;
        $novoTopico->save();

        $novaMensagem = new ForumMensagens;
        $novaMensagem->forum_duvida_id = $novoTopico->id;
        $novaMensagem->user_id = $user;
        $novaMensagem->mensagem = $request->mensagem;
        $novaMensagem->save();
    
        return redirect()->action('DisciplinaController@pagDisciplina', ['cadeira_id' => $request->cadeira_id]);
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
        $user = Auth::user()->getUser()->id;
        $id = $_GET['id'];
        $grupos = Grupo::where('projeto_id', $id)->get();
        $elementos = DB::table('users_grupos')->get();    
        $projeto = Projeto::where('id', $id)->first();
        $users = DB::table('users')->get();
        
        $data = array(
            'grupos'    => $grupos,
            'elementos' => $elementos,
            'projeto'   => $projeto,
            'user'      => $user,
            'users'     => $users
        );

        $returnHTML = view('aluno.grupos')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
    }

    public function showGrup (Request $request) {
        $user = Auth::user()->getUser()->id;
        $id = 1;
        $grupos = Grupo::where('projeto_id', $id)->get();
        $elementos = DB::table('users_grupos')->get();    
        $projeto = Projeto::where('id', $id)->first();
        $users = DB::table('users')->get();
        
        $data = array(
            'grupos'    => $grupos,
            'elementos' => $elementos,
            'projeto'   => $projeto,
            'user'      => $user,
            'users'     => $users
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
    public function indexDocente(int $id, $tab = "tab1") {
        $projetos = DB::select('select p.id, p.nome, p.data_fim, pf.nome as ficheiro 
                                from projetos p
                                left join projetos_ficheiros pf
                                    on p.id = pf.projeto_id
                                where p.cadeira_id = ?', [$id]);
                                // error_log( print_r($projetos, TRUE) );
        $cadeira = Cadeira::where('id', $id)->first();
        $docentes = User::join('users_cadeiras', 'users.id', '=', 'users_cadeiras.user_id')
                          ->where('users.perfil_id', 2)
                          ->where('users_cadeiras.cadeira_id', $cadeira->id)->get();

        $active_tab = $tab;
        return view('disciplina.indexDocente', compact('projetos', 'cadeira', 'docentes', 'active_tab'));
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

    public function getPagInicial() {

    }

    public function getForum(Request $request) {
        $cadeira_id = $_GET['id'];
        $duvidas = DB::select('select fd.*, u1.nome as "primeiro", u2.nome as "ultimo"
                                from forum_duvidas fd
                                inner join users u1
                                on fd.primeiro_user = u1.id
                                inner join users u2
                                on fd.ultimo_user = u2.id
                                where fd.cadeira_id = (?)', [$cadeira_id]);
        // $mensagens = ForumMensagens::join('forum_duvidas', 'forum_duvida_id', '=', 'forum_duvidas.id')->get();

        $data = array(
            'cadeira_id'  => $cadeira_id,
            'duvidas' => $duvidas
        );

        $returnHTML = view('disciplina.forum')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
    }

    public function addTopicoDocent(Request $request){
        $user = Auth::user()->getUser()->id;

        $novoTopico = new ForumDuvidas;
        $novoTopico->assunto = $request->assunto;
        $novoTopico->primeiro_user = $user;
        $novoTopico->ultimo_user = $user;
        $novoTopico->cadeira_id = $request->cadeira_id;
        $novoTopico->save();

        $novaMensagem = new ForumMensagens;
        $novaMensagem->forum_duvida_id = $novoTopico->id;
        $novaMensagem->user_id = $user;
        $novaMensagem->mensagem = $request->mensagem;
        $novaMensagem->save();
    
        return redirect()->action('DisciplinaController@pagDisciplina', ['cadeira_id' => $request->cadeira_id]);
    }

    public function verMensagensDocente(Request $request) {
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

    public function addMensagemDocente(Request $request){
        $user = Auth::user()->getUser()->id;

        ForumDuvidas::update(['ultimo_user'=>$user]);

        $novaMensagem = new ForumMensagens;
        $novaMensagem->forum_duvida_id = $request->duvida_id;
        $novaMensagem->user_id = $user;
        $novaMensagem->mensagem = $request->mensagem;
        $novaMensagem->save();
    
        return redirect()->action('DisciplinaController@pagDisciplina', ['cadeira_id' => $request->cadeira_id]);
    }
}
