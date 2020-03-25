<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Grupo;
use App\Projeto;
use App\Cadeira;
use Illuminate\Support\Facades\DB;
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
    public function indexDocente(int $id)
    {
        $projetos = Projeto::where('cadeira_id', $id)->get();
        $cadeira = Cadeira::where('id', $id)->first();
        return view('disciplina.indexDocente', compact('projetos', 'cadeira'));
    }

    public function showGrupos(Request $request) {
        $id = $_GET['id'];
        $grupos = Grupo::where('projeto_id', $id)->get();
        $projeto = Projeto::where('id', $id)->first();

        $data = array(
            'grupos'  => $grupos,
            'projeto' => $id,
            'max_elementos' => $projeto->n_max_elementos
        );

        $returnHTML = view('disciplina.grupos')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
    }

    public function addGrupo(Request $request) {
        $id = $_GET['id'];
        $numero = Grupo::where('projeto_id', $id)->max('numero');
        $projeto = Projeto::where('id', $id)->first();
        
        $grupo = new Grupo;
        $grupo->projeto_id = $id;
        $grupo->numero = ($numero == null ? 1 : $numero + 1);
        $grupo->save();

        return response()->json(['numero' => ($numero == null ? 1 : $numero + 1), 'max_elem' => $projeto->n_max_elementos]);
    }
}
