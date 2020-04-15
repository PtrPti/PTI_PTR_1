<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Projeto;
use App\UserCadeira;
use App\Cadeira;
use App\Grupo;
use Illuminate\Support\Facades\DB;
use Auth;
use DateTime;

class ProjetoController extends Controller
{
    public function index($tab = "tab1"){
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

    public function id_projetos(int $id){
        $projeto = Projeto::where('id', $id)->first();
        $user = Auth::user()->getUser();
        $id_disciplina = $projeto->cadeira_id;
        $cadeira = Cadeira::where('id', $id_disciplina)->first();
        $grupos = Grupo::where('projeto_id', $id)->get();
        $gruposcount = $grupos->count(); 

        error_log($cadeira->nome);

        return view ('projeto.paginaProjetos', compact('projeto', 'cadeira', 'gruposcount', 'grupos')); 
    }

    public function eraseProject($id){
        DB::delete('delete from projetos where id=?', [$id]);
        echo "Record deleted successfully.<br/>";
        return redirect()->action('HomeController@indexDocente', ['tab' => 'tab2']);
    }    
}