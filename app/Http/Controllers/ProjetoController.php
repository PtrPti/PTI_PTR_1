<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Projeto;
use App\UserCadeira;
use App\Cadeira;
use App\Grupo;
use App\Tarefa;
use App\Feedback;
use App\GrupoFicheiros;
use App\UsersGrupos;
use App\FeedbackFicheiros;
use App\TarefasFicheiros;
use App\AvaliacaoMembros;
use App\AvaliacaoDocente;
use App\Http\Controllers\ChatController;
use App\Http\Requests\TarefaPost;
use App\Http\Requests\TarefaPastaPost;
use App\Http\Requests\TarefaLinkPost;
use App\Http\Requests\TarefaFilePost;
use App\Http\Requests\TarefaNotaPost;
use App\Http\Requests\CreateFeedback;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Auth;
use DateTime;
use Session;

class ProjetoController extends Controller
{
    public function index(Request $request, int $id, int $tab = 1) { #id = grupo_id
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

        #grupo (id)
        $grupo = Grupo::where('id', $id)->first();
        #projeto (nome)
        $projeto = Projeto::join('grupos', 'projetos.id', '=', 'grupos.projeto_id')->select('projetos.*')->where('grupos.id', $id)->first();
        #disciplina (nome)
        $disciplina = Cadeira::where('id', $projeto->cadeira_id)->first();
        #ficheiros grupo
        $ficheiros = GrupoFicheiros::where('grupo_id',$id)->where('pasta_id', null)->orderBy('is_folder','desc')->orderBy('notas', 'asc')->orderBy('link', 'asc')->orderBy('nome', 'asc')->get();
        $subFicheiros = GrupoFicheiros::where('grupo_id',$id)->where('pasta_id', '!=', null)->orderBy('is_folder','desc')->orderBy('nome', 'asc')->get();

        $pastasSelect = GrupoFicheiros::where('grupo_id', $id)->where('is_folder', 1)->where('pasta_id', null)->orderBy('nome', 'asc')->get();

        #tarefas nao feitas 
        $tarefasNaoFeitas = DB::select('call GetTarefas(?,?,?)', [$id, false, null]);
        #tarefas feitas
        $tarefasFeitas = DB::select('call GetTarefas(?,?,?)', [$id, true, null]);
        #ficheiros tarefas
        $tarefasIds = Tarefa::select('id')->where('grupo_id', $id)->get();
        $ids = [];
        foreach ($tarefasIds as $tarefa) {
            array_push($ids, $tarefa->id);
        }
        $ficheirosTarefas = TarefasFicheiros::whereIn('tarefa_id', $ids )->get();
        
        #feedback
        $feedbacks = Feedback::where('grupo_id', $id)->whereNull('mensagem_id')->orderBy('created_at', 'desc')->get();
        #membros
        $membros = UsersGrupos::join('users', 'users_grupos.user_id', '=', 'users.id')->
                    join('users_info', 'users.id', '=', 'users_info.user_id')
                    ->select('users.id', 'users.nome', 'users_info.numero')->where('users_grupos.grupo_id', $id)->get();
        #progresso
        $progresso = $this->barraProgresso($id);
        #ficheiros p/ feedback
        $first = GrupoFicheiros::where('link', null)->where('notas', null)->where('is_folder', false)->where('grupo_id', $id)->select('id', 'nome', DB::raw("'grupo' as tipo"));
        $feedFicheiros = TarefasFicheiros::where('link', null)->where('notas', null)->whereIn('tarefa_id', $tarefasIds)->select('id', 'nome', DB::raw("'ficheiro' as tipo"))->union($first)->get();
        #avaliacoes dos membros
        $avaliacoes = AvaliacaoMembros::join('users', 'avaliacao_membros.membro_avaliado', '=', 'users.id')->where('grupo_id',$id)->where('avaliado_por', $user->id)->select('users.id', 'users.nome','avaliacao_membros.avaliado_por', 'avaliacao_membros.grupo_id', 'avaliacao_membros.nota')->get();
    
        $avaliacoesDocente = AvaliacaoDocente::join('users', 'avaliacao_docente.user_id', '=', 'users.id')->where('grupo_id',$id)->select('users.id', 'users.nome', 'avaliacao_docente.avaliacao')->get();
        $active_tab = $tab;
        
        Session::has('search') ? Session::forget('search') : null;

        return view('grupo.indexGrupo', compact('disciplinas','projetos','utilizadores','grupo','disciplina','projeto',
                                                'tarefasNaoFeitas', 'tarefasFeitas','ficheirosTarefas', 'feedbacks', 'active_tab', 'ficheiros', 
                                                'subFicheiros', 'progresso', 'membros', 'pastasSelect', 'feedFicheiros', 'avaliacoes', 'avaliacoesDocente'));
    }

    public function verFeedback(Request $request) {
        $id = $_GET['id'];
        $user = $_GET['user'];

        //$feedback = Feedback::leftJoin('users', 'feedback.docente_id', '=', 'users.id')->where('feedback.id', $id)->first();
        $assunto = Feedback::where('id',$id)->get();
        $feedback = Feedback::leftJoin('users as u1', 'feedback.user_id', '=', 'u1.id')
                                ->leftJoin('users as u2', 'feedback.docente_id', '=', 'u2.id' )
                                ->select('feedback.*', 'u1.nome as aluno', 'u2.nome as docente')
                                ->where('feedback.mensagem_id',$id)
                                ->orderBy('feedback.created_at', 'asc')->get();
        $feedbackFicheiros = FeedbackFicheiros::leftJoin('tarefas_ficheiros', 'feedback_ficheiros.tarefa_ficheiro_id', '=', 'tarefas_ficheiros.id')
                                                ->leftJoin('grupos_ficheiros', 'feedback_ficheiros.grupo_ficheiro_id', '=', 'grupos_ficheiros.id')
                                                ->select('tarefas_ficheiros.id as tf_id', 'tarefas_ficheiros.nome as tf_nome', 'grupos_ficheiros.id as gf_id', 'grupos_ficheiros.nome as gf_nome')
                                                ->where('feedback_ficheiros.feedback_id', $id)->get();

        $projeto = Feedback::join('grupos', 'feedback.grupo_id', '=', 'grupos.id')->
                            join('projetos', 'grupos.projeto_id', '=', 'projetos.id')->
                            select('projetos.*')->where('feedback.id', $id)->first();

        $data = array(
            'assunto'  => $assunto,
            'feedback'  => $feedback,
            'feedbackFicheiros'  => $feedbackFicheiros,
            'projeto' => $projeto
        );

        $returnHTML = view('grupo.feedbackMensagens')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
    }

    public function sendFeedback(Request $request) {
        $id = $_POST['id'];
        $grupoId = $_POST['grupo_id'];
        $alunoId = $_POST['aluno_id'];
        $docenteId = $_POST['docente_id'];
        $mensagem = $_POST['mensagem'];

        $newFeedback = new Feedback;
        $newFeedback->mensagem_id = $id;
        $newFeedback->mensagem = $mensagem;
        $newFeedback->grupo_id = $grupoId;

        if ( $docenteId == "" ){
            $newFeedback->user_id = $alunoId;
        } else {
            $newFeedback->docente_id = $docenteId;
        }

        $newFeedback->save();

        $assunto = Feedback::where('id',$id)->get();
        $feedback = Feedback::where('mensagem_id',$id)->orderBy('created_at', 'asc')->get();
        $feedbackFicheiros = FeedbackFicheiros::leftJoin('tarefas_ficheiros', 'feedback_ficheiros.tarefa_ficheiro_id', '=', 'tarefas_ficheiros.id')
                                                ->leftJoin('grupos_ficheiros', 'feedback_ficheiros.grupo_ficheiro_id', '=', 'grupos_ficheiros.id')
                                                ->select('tarefas_ficheiros.id as tf_id', 'tarefas_ficheiros.nome as tf_nome', 'grupos_ficheiros.id as gf_id', 'grupos_ficheiros.nome as gf_nome')
                                                ->where('feedback_ficheiros.feedback_id', $id)->get();

        $projeto = Feedback::join('grupos', 'feedback.grupo_id', '=', 'grupos.id')->
                            join('projetos', 'grupos.projeto_id', '=', 'projetos.id')->
                            select('projetos.*')->where('feedback.id', $id)->first();

        $data = array(
            'assunto'  => $assunto,
            'feedback'  => $feedback,
            'feedbackFicheiros'  => $feedbackFicheiros,
            'projeto' => $projeto
        );

        $returnHTML = view('grupo.feedbackMensagens')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
    }

    public function barraProgresso(Int $id) {
        $tarefas = Tarefa::where('grupo_id', $id)->get();
        $ids = [];
        $tarefasDone = 0;
        foreach ($tarefas as $tarefa){
            foreach ($tarefas as $subtarefa){
                if ($tarefa->tarefa_id === NULL and $tarefa->id == $subtarefa->tarefa_id){
                    if ( !in_array($tarefa->id , $ids)){
                        array_push($ids, $tarefa->id);
                    }
                    if($subtarefa->estado){
                        $tarefasDone ++;
                    }
                }
            }
            if ( !in_array($tarefa->id, $ids) and $tarefa->tarefa_id === NULL){
                if($tarefa->estado){
                    $tarefasDone ++;
                }
            }
        }
        $totalTarefas = count($tarefas) - count($ids);
        $percentagem =  $totalTarefas == 0 ? 0 : round($tarefasDone*100/$totalTarefas);
        return $percentagem;
    }

    public function createTarefa(TarefaPost $request) {
        $nome = $_POST['nomeTarefa'];
        $membro = $_POST['membro'];
        $tarefaAssociada = $_POST['tarefaAssociada'];
        $prazo = $_POST['prazo'];
        $grupoId = $_POST['grupo_id'];
        $projetoId = $_POST['projeto_id'];

        if( $tarefaAssociada == "" ){
            $ordem = Tarefa::where('projeto_id', $projetoId)->whereNull('tarefa_id')->max('ordem');
            $ordem = $ordem + 1;
        }else{
            $ordem = Tarefa::where('projeto_id', $projetoId)->where('tarefa_id',$tarefaAssociada)->max('ordem');
            $ordem = $ordem + 1;
        }
        
        $novaTarefa = new Tarefa;
        $novaTarefa->nome = $nome;
        $novaTarefa->user_id = $membro == "" ? null : $membro;
        $novaTarefa->grupo_id = $grupoId;
        $novaTarefa->projeto_id = $projetoId;
        $novaTarefa->prazo = $prazo == "" ? null : $membro;
        $novaTarefa->tarefa_id = $tarefaAssociada == "" ? null : $tarefaAssociada;
        $novaTarefa->ordem = $ordem;
        $novaTarefa->save();

        return response()->json(['title' => 'Sucesso', 'msg' => 'Tarefa criada com sucesso', 'redirect' => '/Home/Projeto/Grupo/'. $grupoId . '/1' ]);
    }

    public function editTarefa(Request $request) {
        $id = $_GET['tarefa_id'];
        $tarefa = Tarefa::find($id);
        $projetoId = $tarefa->projeto_id;

        if(is_null($tarefa->tarefa_id) ){
            $ordens = Tarefa::select('nome')->where('projeto_id', $projetoId)->where('id','!=',$id)->whereNull('tarefa_id')->orderBy('ordem')->get();
        }else{
            $ordens = Tarefa::select('nome')->where('tarefa_id',$tarefa->tarefa_id)->where('id','!=',$id)->orderBy('ordem')->get();
        }   
        $tarefasNomes = array();
        foreach ($ordens as $ord){
            array_push($tarefasNomes,$ord->nome);
        }
        return response()->json(
            array(  'nome'=>$tarefa->nome, 
                    'membro'=>$tarefa->user_id, 
                    'prazo'=>$tarefa->prazo, 
                    'tarefaAssoc'=>$tarefa->tarefa_id,
                    'tarefasNomes'=> $tarefasNomes,
                    'ordem' => $tarefa->ordem
                ));
    }

    public function editTarefaPost(TarefaPost $request) {
        $id = $_POST['tarefa_id'];
        $nome = $_POST['nomeTarefa'];
        $membro = $_POST['membro'];
        $tarefaAssociada = $_POST['tarefaAssociada'];
        $prazo = $_POST['prazo'];
        $grupoId = $_POST['grupo_id'];
        $ordemNova = $_POST['ordem'];

        $tarefa = Tarefa::find($id);

        $projetoId = $tarefa->projeto_id;
        $tarefa->nome = $nome;
        $tarefa->user_id = $membro == "" ? null : $membro;
        $tarefa->prazo = $prazo == "" ? null : $membro;
        $tarefa->tarefa_id = $tarefaAssociada == "" ? null : $tarefaAssociada;
        
        $ordemAnt = $tarefa->ordem;
        
        if ($ordemAnt > $ordemNova){
            if( $tarefaAssociada == "" ){
                $tarefasUp = Tarefa::where('projeto_id', $projetoId)->where('ordem','>=', $ordemNova)->whereNull('tarefa_id')->get();
                foreach($tarefasUp as $taref){
                    $ord = $taref->ordem + 1;
                    $taref->ordem = $ord;
                    $taref->save();
                }
            }else{
                $tarefasUp = Tarefa::where('projeto_id', $projetoId)->where('ordem','>=', $ordemNova)->where('tarefa_id',$tarefaAssociada)->get();
                foreach($tarefasUp as $taref){
                    $ord = $taref->ordem + 1;
                    $taref->ordem = $ord;
                    $taref->save();
                }
            }

        } else {
            if( $tarefaAssociada == "" ){
                error_log($ordemAnt); 
                error_log($ordemNova);
                $tarefasUp = Tarefa::where('projeto_id', $projetoId)->whereBetween('ordem', [$ordemAnt+1, $ordemNova])->whereNull('tarefa_id')->get();
                
                foreach($tarefasUp as $taref){
                    $ord = $taref->ordem - 1;
                    $taref->ordem = $ord;
                    $taref->save();
                }
            }else{
                $tarefasUp = Tarefa::where('projeto_id', $projetoId)->where('tarefa_id',$tarefaAssociada)->whereBetween('ordem', [$ordemAnt+1, $ordemNova])->get();
                foreach($tarefasUp as $taref){
                    $ord = $taref->ordem - 1;
                    $taref->ordem = $ord;
                    $taref->save();
                }
            }
        }

        $tarefa->ordem = $ordemNova;
           
        $tarefa->save();

        return response()->json(['title' => 'Sucesso', 'msg' => 'Tarefa alterada com sucesso', 'redirect' => '/Home/Projeto/Grupo/'. $grupoId . '/1' ]);
    }

    public function checkTarefa(Request $request) {
        $id = $_POST['id'];
        $val = $_POST['val'] == "false" ? FALSE : TRUE;
        $finished_time = $val == TRUE ? date('Y-m-d H:i:s') : null; 

        if ($_POST['changePai'] == "true") {
            $pai = Tarefa::select('tarefa_id')->where('id',$id)->first();
            Tarefa::where('id', $pai->tarefa_id)->update(['estado'=>$val,'finished_at'=>$finished_time]);
        }
        //Atualiza as tarefas filhos para o estado do pai
        Tarefa::where('tarefa_id', $id)->update(['estado'=>$val,'finished_at'=>$finished_time]);

        $tarefa = Tarefa::find($id);
        $tarefa->estado = $val;
        $tarefa->finished_at = $finished_time;
        $tarefa->save();

        // Id do grupo
        $grupo = Tarefa::select('grupo_id')->where('id',$id)->first();    
        $progresso = $this->barraProgresso($grupo->grupo_id);        
        
        if ($_POST['update'] == "true") {
            $projeto = Projeto::join('grupos', 'projetos.id', '=', 'grupos.projeto_id')->select('projetos.*')->where('grupos.id', $grupo->grupo_id)->first();

            $tarefasIds = Tarefa::select('id')->where('grupo_id', $id)->get();
            $ids = [];
            foreach ($tarefasIds as $tarefa) {
                array_push($ids, $tarefa->id);
            }
            $ficheirosTarefas = TarefasFicheiros::whereIn('tarefa_id', $ids )->get();

            $tarefasNaoFeitas = DB::select('call GetTarefas(?,?,?)', [$grupo->grupo_id, false, null]);
            $tarefasFeitas = DB::select('call GetTarefas(?,?,?)', [$grupo->grupo_id, true, null]);
            #membros
            $membros = UsersGrupos::join('users', 'users_grupos.user_id', '=', 'users.id')->select('users.id', 'users.nome')->where('users_grupos.grupo_id', $grupo->grupo_id)->get();

            $data = array('progresso' => $progresso, 'tarefasNaoFeitas' => $tarefasNaoFeitas, 'tarefasFeitas' => $tarefasFeitas, 
                        'grupo_id' => $grupo->grupo_id, 'membros'=>$membros, 'projeto' => $projeto, 'ficheirosTarefas' => $ficheirosTarefas);
            $returnHTML = view('grupo.tarefas')->with($data)->render();
            return response()->json(array('html' => $returnHTML, 'title' => 'Sucesso', 'msg' => 'Tarefa alterada com sucesso'));
        }
        else {
            return response()->json(array('progresso'=>$progresso, 'title' => 'Sucesso', 'msg' => 'Tarefa alterada com sucesso'));
        }
    }

    public function createPasta(TarefaPastaPost $request) {
        $nome = $_POST['nomePasta'];
        $grupoId = $_POST['grupo_id'];

        $pasta = new GrupoFicheiros;
        $pasta->grupo_id = $grupoId;
        $pasta->nome = $nome;
        $pasta->is_folder = TRUE;
        $pasta->save();

        return response()->json(['title' => 'Sucesso', 'msg' => 'Pasta criada com sucesso', 'redirect' => '/Home/Projeto/Grupo/'. $grupoId . '/1' ]);
    }

    public function addNotaGrupo(TarefaNotaPost $request) {
        $pastaId = $_POST['notaPasta'];
        $nome = $_POST['nomeNota'];
        $texto = $_POST['notaTexto'];
        $grupoId = $_POST['grupo_id'];

        $nota = new GrupoFicheiros;
        $nota->is_folder = FALSE;
        $nota->pasta_id = $pastaId == "" ? null : $pastaId;
        $nota->grupo_id = $grupoId;
        $nota->nome = $nome;
        $nota->notas = $texto;
        $nota->save();

        return response()->json(['title' => 'Sucesso', 'msg' => 'Nota criada com sucesso', 'redirect' => '/Home/Projeto/Grupo/'. $grupoId . '/1' ]);
    }

    public function addNotaTarefa(TarefaNotaPost $request) {
        $nome = $_POST['nomeNota'];
        $texto = $_POST['notaTexto'];
        $grupoId = $_POST['grupo_id'];
        $tarefaId = $_POST['tarefa_id'];

        $nota = new TarefasFicheiros;
        $nota->tarefa_id = $tarefaId;
        $nota->nome = $nome;
        $nota->notas = $texto;
        $nota->save();

        return response()->json(['title' => 'Sucesso', 'msg' => 'Nota criada com sucesso', 'redirect' => '/Home/Projeto/Grupo/'. $grupoId . '/1' ]);
    }

    public function addLinkGrupo(TarefaLinkPost $request) {
        $pastaId = $_POST['linkPasta'];
        $nome = $_POST['nomeLink'];
        $link = $_POST['url'];
        $grupoId = $_POST['grupo_id'];
        
        $site = new GrupoFicheiros;

        $site->grupo_id = $grupoId;
        $site->pasta_id = $pastaId == "" ? null : $pastaId;
        $site->nome = $nome;
        $site->link = $link;
        $site->save();

        return response()->json(['title' => 'Sucesso', 'msg' => 'Link adicionado com sucesso', 'redirect' => '/Home/Projeto/Grupo/'. $grupoId . '/1' ]);
    }

    public function addLinkTarefa(TarefaLinkPost $request) {
        $nome = $_POST['nomeLink'];
        $link = $_POST['url'];
        $tarefaId = $_POST['tarefa_id'];
        $grupoId = $_POST['grupo_id'];

        $site = new TarefasFicheiros;
        $site->nome = $nome;
        $site->tarefa_id = $tarefaId;
        $site->link = $link;
        $site->save();

        return response()->json(['title' => 'Sucesso', 'msg' => 'Link adicionado com sucesso', 'redirect' => '/Home/Projeto/Grupo/'. $grupoId . '/1' ]);
    }

    public function addFileGrupo(TarefaFilePost $request) {
        $grupoId = $_POST['grupo_id'];
        $pastaId = $_POST['filePasta'];

        if (Input::hasFile('grupoFile')) {
            $filename = $grupoId . '_' . $request->file('grupoFile')->getClientOriginalName();
            $request->file('grupoFile')->storeAs('public/grupo', $filename);

            $ficheiro = new GrupoFicheiros();
            $ficheiro->nome = $filename;
            $ficheiro->grupo_id = $grupoId;
            $ficheiro->is_folder = FALSE;
            $ficheiro->pasta_id = $pastaId == "" ? null : $pastaId;
            $ficheiro->save();
        }

        return redirect()->action('ProjetoController@index',['id'=>$grupoId]);
    }

    public function addFileTarefa(TarefaFilePost $request) {
        $tarefaId = $_POST['tarefa_id'];
        $grupoId = $_POST['grupo_id'];

        if (Input::hasFile('grupoFile')) {
            $filename = $tarefaId . '_' . $request->file('grupoFile')->getClientOriginalName();
            $request->file('grupoFile')->storeAs('public/tarefa', $filename);

            $file = new TarefasFicheiros;
            $file->tarefa_id = $tarefaId;
            $file->nome = $filename;
            $file->save();
        }

        return redirect()->action('ProjetoController@index',['id'=>$grupoId]);
    }

    public function pesquisarTarefas(Request $request) {
        $search = $_GET['search'];
        $grupoId = $_GET['grupo_id'];
        $clear = $_GET['clear'];

        $search == "" ? (Session::has('search') ? Session::forget('search') : null) : Session::flash('search', $search);

        $progresso = $this->barraProgresso($grupoId);
        $membros = $membros = UsersGrupos::join('users', 'users_grupos.user_id', '=', 'users.id')->select('users.id', 'users.nome')->where('users_grupos.grupo_id', $grupoId)->get();
        
        if ($clear == "true") {
            $tarefasNaoFeitas = DB::select('call GetTarefas(?,?,?)', [$grupoId, false, null]);
            $tarefasFeitas = DB::select('call GetTarefas(?,?,?)', [$grupoId, true, null]);            
        }
        else{
            $tarefasNaoFeitas = DB::select('call GetTarefas(?,?,?)', [$grupoId, false, $search]);
            $tarefasFeitas = DB::select('call GetTarefas(?,?,?)', [$grupoId, true, $search]);
        }
        
        $projeto = Projeto::join('grupos', 'projetos.id', '=', 'grupos.projeto_id')->select('projetos.*')->where('grupos.id', $grupoId)->first();

        $tarefasIds = Tarefa::select('id')->where('grupo_id', $grupoId)->get();
        $ids = [];
        foreach ($tarefasIds as $tarefa) {
            array_push($ids, $tarefa->id);
        }
        $ficheirosTarefas = TarefasFicheiros::whereIn('tarefa_id', $ids )->get();

        $data = array('progresso' => $progresso, 'tarefasNaoFeitas' => $tarefasNaoFeitas, 'tarefasFeitas' => $tarefasFeitas, 'grupo_id' => $grupoId, 'membros' => $membros, 'projeto' => $projetos, 'ficheirosTarefas' => $ficheirosTarefas);

        $returnHTML = view('grupo.tarefas')->with($data)->render();
        return response()->json(array('html' => $returnHTML));
    }

    public function createFeedback(CreateFeedback $request) {
        $grupoId = $_POST['grupo_id'];
        $alunoId = $_POST['aluno_id'];
        $assunto = $_POST['assunto'];
        $mensagem = $_POST['message'];
        $ids = explode(',' , $_POST['files_ids']);

        // Assunto do feedback
        $feedback1 = new Feedback;
        $feedback1->mensagem = $assunto;
        $feedback1->grupo_id = $grupoId;
        $feedback1->user_id = $alunoId;
        $feedback1->save();

        // Mensagem referente ao Assunto 
        $feedback2 = new Feedback;
        $feedback2->mensagem = $mensagem;
        $feedback2->grupo_id = $grupoId;
        $feedback2->user_id = $alunoId;
        $feedback2->mensagem_id = $feedback1->id;
        $feedback2->save();

        $feedbackId = $feedback1->id;

        for($i = 0; $i < sizeof($ids) - 1; $i++) {
            $feedbackFicheiro = new FeedbackFicheiros;
            $feedbackFicheiro->feedback_id = $feedbackId;

            if (explode('_' , $ids[$i])[1] == "grupo") {
                $feedbackFicheiro->grupo_ficheiro_id = explode('_' , $ids[$i])[0];
            }
            else {
                $feedbackFicheiro->tarefa_ficheiro_id = explode('_' , $ids[$i])[0];                
            }
            $feedbackFicheiro->save();
        }

        

        return response()->json(['title' => 'Sucesso', 'msg' => 'Feedback criado com sucesso', 'redirect' => '/Home/Projeto/Grupo/'. $grupoId . '/2' ]);
    }

    public function addMensagemFeedbackDocente(Request $request){
        $this->validate($request, [
            'mensagem_docente' => 'bail|required|string|max:4000',]);

        $id = $request->grupo_id;
        $feedback = Feedback::find($_POST['id']);
        $feedback->mensagem_docente = $request->mensagem_docente;
        $feedback->docente_id =$request->docente_id;
        $feedback->vista_docente = TRUE;

        $feedback->save();
    
        return redirect()->action('ProjetoController@GrupoDocente', ['id_grupo' => $id] );
    }

    public function addAvaliacao (Request $request) {     
        $lista_membros = UsersGrupos::where('grupo_id', $request->grupo_id)->get();

        foreach($lista_membros as $membro){
            $aval = new AvaliacaoMembros;
            $aval->avaliado_por = Auth::user()->getUser()->id;
            $aval->membro_avaliado = $membro->user_id;
            $aval->grupo_id = $request->grupo_id;
            $nota_membro = "nota_".$membro->user_id;
            $aval->nota = $request->$nota_membro;
            $aval->save();
        }

        return redirect()->action('ProjetoController@index',['id'=>$request->grupo_id, 'tab'=>4]);
    }

    public function avaliar(Request $request) {     
        $lista_membros = UsersGrupos::where('grupo_id', $request->grupo_id)->get();
        
        foreach($lista_membros as $membro){
            $aval = new AvaliacaoDocente;
            $aval->user_id = $membro->user_id;
            $aval->grupo_id = $request->grupo_id;
            $nota_membro = "nota_".$membro->user_id;
            $aval->avaliacao = $request->$nota_membro;
            $aval->save();
        }

        return redirect()->action('ProjetoController@index',['id'=>$request->grupo_id, 'tab'=>4]);
    }
    
    public function infoNota(Request $request) {
        $tipo = $_GET['tipo']; 
        $id = $_GET['id'];  

        if($tipo == 'grupo'){
            $nota = GrupoFicheiros::where('id',$id)->get();

        } else {
            $nota = TarefasFicheiros::where('id',$id)->get();
        }

        $data = array('nota' => $nota, 'tipo'=> $tipo);
        $returnHTML = view('grupo.nota')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
    }

    public function saveNota(Request $request) {
        $tipo = $_GET['tipo']; 
        $id = $_GET['id'];
        $nota = $_GET['nota'];

        if($tipo == 'grupo'){
            $notaa = GrupoFicheiros::find($id);
            $notaa->notas = $nota;
            $notaa->save();
            $nota = GrupoFicheiros::where('id',$id)->get();
        } else {
            $notaa = TarefasFicheiros::find($id);
            $notaa->notas = $nota;
            $notaa->save();
            $nota = TarefasFicheiros::where('id',$id)->get();
        }

        $data = array('nota' => $nota, 'tipo'=> $tipo);
        $returnHTML = view('grupo.nota')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
    }

    public function remover(Request $request) {
        $tipo = $_GET['tipo']; 
        $id = $_GET['id'];
        $grupoId = $_GET['grupoId'];
        
        if($tipo == 'grupo'){
            
            $ficheiro = GrupoFicheiros::find($id);
            if ($ficheiro->is_folder){
                $deletedRows = GrupoFicheiros::where('pasta_id', $id)->delete();
            } else{
                if(Storage::disk('local')->exists($ficheiro->nome)){
                    Storage::delete($ficheiro->nome); 
                }
            }
            $ficheiro->delete();
            
        } else {
            $ficheiro = TarefasFicheiros::find($id);
            if(Storage::disk('local')->exists($ficheiro->nome)){
                Storage::delete($ficheiro->nome); 
            }
            $ficheiro->delete();
        }

        return response()->json(['title' => 'Sucesso', 'msg' => 'Removido com sucesso', 'redirect' => '/Home/Projeto/Grupo/'. $grupoId . '/1' ]);
    }


    public function search_projetos(Request $request){
        $user = Auth::user()->getUser();
        $user_id = $user->id;
        $search = $_GET['search'];

        $query_p = Projeto::join('cadeiras', 'projetos.cadeira_id', '=', 'cadeiras.id')->join('users_cadeiras', 'cadeiras.id', '=', 'users_cadeiras.cadeira_id')
        ->join('grupos', 'projetos.id', '=', 'grupos.projeto_id')->join('users_grupos', 'grupos.id', '=', 'users_grupos.grupo_id')
        ->where('users_grupos.user_id', '=', $user_id)
        ->where('users_cadeiras.user_id', '=', $user_id)->select('projetos.id as id', 'projetos.nome as nome', 'cadeiras.nome as cadeira', 'grupos.id as grupo_id', 'grupos.numero as numero', 'users_grupos.favorito as favorito', 'users_grupos.id as usersGrupos_id');

        $projetos = $query_p->where('projetos.nome', 'like', '%'.$search.'%')->get();
       

        // $query_p = "select p.id as id, p.nome as nome, c.nome as cadeira, g.id as grupo_id, g.numero as numero, ug.favorito as favorito, ug.id as usersGrupos_id
        //             from projetos p
        //             inner join cadeiras c
        //                 on p.cadeira_id = c.id
        //             inner join users_cadeiras uc
        //                 on c.id = uc.cadeira_id and uc.user_id = ?
        //             inner join grupos g
        //                 on p.id = g.projeto_id
        //             inner join users_grupos ug
        //                 on g.id = ug.grupo_id and ug.user_id = ?";

        // $projetos = Projeto::select($query_p, [$user->id])->where(function($query) use($search) {
           
        //     $query->where('projetos.nome', 'like', '%'.$search.'%')->get();});
        //print_r($projetos);
        $data = ['projetos'=> $projetos, 'mensagem' => 'Não foram encontrados Projetos'];
        
        $returnHTML = view('filtroProjeto')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
       


    }
}
