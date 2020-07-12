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
use App\CursoCadeira;
use App\Curso;
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
use Illuminate\Pagination\LengthAwarePaginator;
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

        $lista_alunos = UserCadeira::join('users', 'users_cadeiras.user_id', '=', 'users.id')->join('users_info', 'users.id', '=', 'users_info.user_id')->
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
                                    g.id, g.numero, 'total_membros', 'elementos'
                                order by g.numero", [$id]);
                                    
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
        $primeiro_numero = $_POST['primeiro_numero'];

        $projeto = Projeto::where('id', $id)->first();

        $numero = Grupo::where('projeto_id', $id)->max('numero');
        $numero = $numero == null ? 0 : $numero;
        
        if ($primeiro_numero != null){
            $numero = $primeiro_numero - 1;
        }
        
        $i = 1;
        $var_bool = TRUE;
        while ($var_bool == TRUE){
            if($i < $n_grupos){ 
                if (Grupo::where('numero', $numero + 1)->where('projeto_id', $id)->first()== null){
                    $grupo = new Grupo;
                    $grupo->projeto_id = $id;
                    $grupo->numero = $numero + 1;
                    $grupo->save();
                    
                    if($entrar == "true") {                
                        UsersGrupos::insert(["user_id" => $user->id, "grupo_id" => $grupo->id]);
                    }
                    $i ++;
                    $numero ++;
                }else{
                    $i --;
                    $numero ++;
                }
            }else{
                $var_bool = FALSE;
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
          $s3= Storage::disk("s3");
            $file = $request->file('projetoFile');
            $filename = $file->getClientOriginalName();
            $s3filepath = "ficheiros/projetos". $projetoId;
            $path= $s3 -> putFileAs($s3filepath, $file, $filename, 'public' );


            $ficheiro = new ProjetoFicheiro();
            $ficheiro->nome = $path;
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

    public function search_alunos(Request $request){

        $search = $_GET['search'];
        $cadeiraId = $_GET['cadeira_id'];
        $cursos_id = [];
        $departamentos_id = [];
        $y = CursoCadeira::select('curso_id')->where('cadeira_id',  $cadeiraId)->get();

        foreach($y as $y1 ){
            array_push($cursos_id, $y1->curso_id);
        }
        $x = Curso::select('departamento_id')->whereIn('id', $cursos_id)->get();

        foreach($x as $x1 ){
            array_push($departamentos_id, $x1->departamento_id);
        }


        $users = User::leftJoin('users_cadeiras', 'users.id', '=', 'users_cadeiras.user_id')->join('users_info', 'users.id', '=', 'users_info.user_id')->select('nome', 'numero', 'users.id as id')->where(function($query) use ($cadeiraId) {
            $query->where('cadeira_id', '!=', $cadeiraId)
                  ->orWhere('cadeira_id', null);
        })->whereIn('curso_id', $cursos_id)->whereIn('departamento_id', $departamentos_id)->where(function($query) use($search) {
            $query->where('nome', 'like', '%'.$search.'%')
                  ->orWhere('numero', 'like', '%'.$search.'%');
        })->get()->mapWithKeys(function ($item) {
            return [$item['nome'].'_'.$item['numero'] => $item['id']];
        });

        return response()->json(array('users' => $users));
    }

    public function addAluno(Request $request){

        $cadeiraId = $_POST['cadeira_id'];
        $user_id = $_POST['user_id'];

        $addUser = new UserCadeira;
        $addUser->user_id = $user_id;
        $addUser->cadeira_id = $request->cadeira_id;
        $addUser->save();

        return redirect()->action('DisciplinaController@index', ['id'=> $request->cadeira_id,  'tab'=> 4]);

    }
}
