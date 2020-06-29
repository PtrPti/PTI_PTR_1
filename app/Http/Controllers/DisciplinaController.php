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
use App\Avaliacao;
use App\Http\Controllers\ChatController;
use App\Http\Requests\ProjectPost;
use App\Http\Requests\ForumTopicoPost;
use App\Http\Requests\AddGrupoPost;
use App\Http\Requests\ReplyForumPost;
use App\Http\Requests\ProjetoFilePost;
use App\Http\Requests\ProjetoLinkPost;
use App\Http\Requests\CreateEvaluation;
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

    public function index(Request $request, int $id, int $tab = 1, int $proj = 0) {
        //Navbar
            $user = Auth::user()->getUser();
            $disciplinas = UserCadeira::join('cadeiras', 'users_cadeiras.cadeira_id', '=', 'cadeiras.id')->where('users_cadeiras.user_id', $user->id)->get();

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
        //Navbar

        $disciplina = Cadeira::where('id', $id)->first();
        $docentes = User::join('users_cadeiras', 'users.id', '=', 'users_cadeiras.user_id')
                          ->where('users.perfil_id', 2)
                          ->where('users_cadeiras.cadeira_id', $id)->get();
        
        $projetos_cadeira = Projeto::where('cadeira_id', $id)->get();

        $duvidas = DB::select('select fd.*, u1.nome as primeiro, u2.nome as ultimo, count(fm.id) as totalMensagens
                            from forum_duvidas fd
                            inner join users u1
                                on fd.primeiro_user = u1.id
                            inner join users u2
                                on fd.ultimo_user = u2.id
                            inner join forum_mensagens fm
                                on fd.id = fm.forum_duvida_id
                            where fd.cadeira_id = (?)
                            group by fd.id', [$id]);
        
        $lista_alunos = UserCadeira::join('users', 'users_cadeiras.user_id', '=', 'users.id')->
                            where('users_cadeiras.cadeira_id', $id)->
                            where('users.perfil_id', 1)->get();

        $active_tab = $tab;

        if ($proj > 0) {
            Session::flash('click', 'proj-' . $proj);
        }

        $avaliacao = DB::table('avaliacao')->select('id','cadeira_id', 'mensagem_criterios')->where('cadeira_id', $id)->get();

        return view('disciplina.indexDisciplina', compact('disciplinas', 'projetos', 'utilizadores', 'disciplina', 'docentes', 'projetos_cadeira', 'duvidas', 'lista_alunos', 'active_tab', 'avaliacao'));
    }

    public function criarProjeto(ProjectPost $request) {
        $projetos = new Projeto;

        $projetos->nome = $request->nome;
        $projetos->cadeira_id = $request->cadeira_id;
        $projetos->n_max_elementos = $request->n_elem;
        $projetos->estado = "";
        $projetos->inscricoes = true;
        $projetos->data_inicio = DateTime::createFromFormat('Y-m-d', $request->datainicio);
        $projetos->data_fim = DateTime::createFromFormat('Y-m-d', $request->datafim);

        $projetos->save(); 

        return response()->json(['title' => 'Sucesso', 'msg' => 'Projeto criado com sucesso', 'redirect' => '/Home/Disciplina/'. $request->cadeira_id  ]);
    }

    public function verMensagensForum(Request $request) {
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

    public function removeUser(Request $request) {
        $user = Auth::user()->getUser();
        $grupo_id = $_POST['grupo_id'];
        UsersGrupos::where([
            ['user_id', '=', $user->id],
            ['grupo_id', '=', $grupo_id],
        ])->delete();
        return response()->json(array('html'=>'Removido com sucesso'));
    }

    public function addUser(Request $request) {
        $user = Auth::user()->getUser();
        $grupo_id = $_POST['grupo_id'];
        UsersGrupos::insert(["user_id" => $user->id, "grupo_id" => $grupo_id]);
        return response()->json(array('html'=>'User adicionado com sucesso'));
    }

    public function showGrupos(Request $request) {
        $id = $_GET['id'];
        $user = Auth::user()->getUser();
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
                                    ->where('users_grupos.user_id', $user->id)->first();
        
        $projFicheiros = ProjetoFicheiro::where('projeto_id', $id)->orderBy('link', 'asc')->get();

        $data = array(
            'grupos'  => $grupos,
            'projFicheiros' => $projFicheiros,
            'projeto' => $projeto,
            'pertenceGrupo' => $pertenceGrupo
        );

        $returnHTML = view('disciplina.grupos')->with($data)->render();
        return response()->json(array('html'=>$returnHTML, 'nome' => $projeto->nome));
    }

    public function addGrupo(AddGrupoPost $request) {
        $user = Auth::user()->getUser();
        $id = $_POST['projeto_id'];
        $n_grupos = $_POST['n_grupos'];
        $entrar = $_POST['entrar'];

        $numero = Grupo::where('projeto_id', $id)->max('numero');
        $numero = $numero == null ? 1 : $numero;

        $projeto = Projeto::where('id', $id)->first();
        
        for ($i = 1; $i <= $n_grupos; $i++, $numero++) {
            $grupo = new Grupo;
            $grupo->projeto_id = $id;
            $grupo->numero = $numero + 1;
            $grupo->save();
            
            if($entrar == "true") {                
                UsersGrupos::insert(["user_id" => $user->id, "grupo_id" => $grupo->id]);
            }
        }

        Session::flash('click', 'proj-'.$projeto->id);
        return response()->json(['title' => 'Sucesso', 'msg' => 'Grupos criados com sucesso', 'redirect' => '/Home/Disciplina/'. $_POST['cadeira_id'] . '/1' ]);
    }

    public function deleteGrupo(Request $request) {
        Grupo::destroy($_POST['id']);

        return response()->json('Apagado com sucesso');
    }

    public function addFileProjeto(ProjetoFilePost $request) {
        $projetoId = $_POST['projeto_id'];

        if (Input::hasFile('projetoFile')) {
            $filename = $request->projeto_id . '_' . $request->file('projetoFile')->getClientOriginalName();
            $request->file('projetoFile')->storeAs('public/projeto', $filename);

            $ficheiro = new ProjetoFicheiro();
            $ficheiro->nome = $filename;
            $ficheiro->projeto_id = $request->projeto_id;
            $ficheiro->save();
        }

        Session::flash('click', 'proj-' . $projetoId);
        return redirect()->action('DisciplinaController@index',['id'=>$_POST['cadeira_id']]);
    }

    public function addLinkProjeto(ProjetoLinkPost $request) {
        $nome = $_POST['link'];
        $link = $_POST['url'];
        $projetoId = $_POST['projeto_id'];
        
        $site = new ProjetoFicheiro;

        $site->projeto_id = $projetoId;
        $site->nome = $nome == "" ? null : $nome;
        $site->link = $link;
        $site->save();

        Session::flash('click', 'proj-' . $projetoId);
        return response()->json(['title' => 'Sucesso', 'msg' => 'Link adicionado com sucesso', 'redirect' => '/Home/Disciplina/'. $_POST['cadeira_id'] . '/1' ]);
    }

    public function addForumTopico(ForumTopicoPost $request) {

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
        
        return response()->json(['title' => 'Sucesso', 'msg' => 'Tópico criado com sucesso', 'redirect' => '/Home/Disciplina/'. $request->cadeira_id . '/5' ]);
    }

    public function replyForum(ReplyForumPost $request) {
        $user = Auth::user()->getUser();

        $bloco = DB::select('select max(bloco) as "bloco" from forum_mensagens where forum_duvida_id = (?) and resposta_a = (?)', [$request->duvida_id, $request->mensagem_id]);

        $resposta = new ForumMensagens();
        $resposta->mensagem = $request->resposta;
        $resposta->resposta_a = $request->mensagem_id;
        $resposta->forum_duvida_id = $request->duvida_id;
        $resposta->user_id = $user->id;
        
        if ($bloco[0]->bloco == null) { //criar um novo nivel -> neste caso é a primeira resposta de todas ou uma respota a outra resposta
            $bloco_pai = DB::select('select bloco from forum_mensagens where forum_duvida_id = (?) and id = (?)', [$request->duvida_id, $request->mensagem_id]); //vai buscar o bloco do pai/nivel superior
            if ($bloco_pai[0]->bloco == 0) { //resposta a mensagem de criacao do topico (1a mensagem de todas)
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

        Session::flash('click', 'duvida-'.$request->duvida_id);
        return response()->json(['title' => 'Sucesso', 'msg' => 'Resposta enviada com sucesso', 'redirect' => '/Home/Disciplina/'. $request->cadeira_id . '/5' ]);
    }


    public function addEvaluation(CreateEvaluation $request){

        $msg_criterios = $_POST['mensagem_criterios'];
        $cadeiraId = $_POST['cadeira_id'];
        
        $avaliacao = new Avaliacao;
        $avaliacao->mensagem_criterios = $request->mensagem_criterios;
        $avaliacao->cadeira_id = $request->cadeira_id;
        $avaliacao->save();
        //$avaliacaoId = $avaliacao->id;


        //return response()->json(['title' => 'Sucesso', 'msg' => 'Critério criado com sucesso', 'redirect' => '/Home/Disciplina'. $request->cadeira_id . '/2' ]);
        return redirect()->action('DisciplinaController@index', ['id'=> $request->cadeira_id, 'tab'=> 2]);
    }


    public function verAvaliacaoDisciplina(Request $request) {
        $msg_criterios = $_GET['mensagem_criterios'];
        $id_cadeira = $_GET['id_cadeira'];

        $mensagem = DB::table('avaliacao')->select('mensagem_criterios')->where('cadeira_id', $id_cadeira )->first();

        $data = array(
            
            'mensagem_criterios'  => $mensagem,
            'id_cadeira'=> $id_cadeira
            
        );

        $returnHTML = view('disciplina.indexDisciplina')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
        //return redirect()->action('DisciplinaController@indexDocente');
    }


    public function changeEvaluation(Request $request){
        
        $nova_mensagem = $_POST['nova_mensagem'];
        $cadeiraId = $_POST['cadeira_id'];
        $id = $_POST['id'];

        $mensagem = DB::table('avaliacao')->select('mensagem_criterios')->where('id', $id)->where('cadeira_id', $cadeiraId )->update(['mensagem_criterios' => $nova_mensagem]);
        return redirect()->action('DisciplinaController@index', ['id'=> $request->cadeira_id,  'tab'=> 2]);
    }


    public function eraiseEvaluation(Request $request){
        $cadeiraId = $_POST['cadeira_id'];
        $id = $_POST['id'];

        $mensagem = DB::table('avaliacao')->select('mensagem_criterios')->where('id', $id)->where('cadeira_id', $cadeiraId )->delete();
        
        return redirect()->action('DisciplinaController@index', ['id'=> $request->cadeira_id,  'tab'=> 2]);
    }


    public static function search_alunos($cadeiras_id, $user_id, $departamento_id, $search = "") {
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
            inner join users_cadeiras uc
                on u.id = uc.user_id
                and uc.cadeira_id in (:cadeiras)
            left join messages m
                on u.id = m.from
                and id_read = 0 
                and m.to = :u1
            left join (select * from messages order by created_at desc) as m2
                on (m2.from = :u2 and m2.to = u.id)
                or (m2.to = :u3 and m2.from = u.id)
            where u.id != :u4 and u.departamento_id = :d " . $search .
            " group by u.id, u.nome, u.email"), ['cadeiras' => implode("','", $cadeiras_id), 'u1' => $user_id, 'u2' => $user_id, 'u3' => $user_id, 'u4' => $user_id, 'd' => $departamento_id]
        );
        
        return $utilizadores;
    }


    public function search_aluno(Request $request){

        $user_id = $_POST['user_id'];
        $cadeiraId = $_POST['cadeira_id'];
        
        $addUser = new UserCadeira;
        $addUser->user_id = $request->user_id;
        $addUser->cadeira_id = $request->cadeira_id;
        $addUser->save();

        return redirect()->action('DisciplinaController@index', ['id'=> $request->cadeira_id, 'tab'=> 4]);

        


    }




}
