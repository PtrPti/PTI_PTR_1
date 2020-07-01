<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Projeto;
use App\UserCadeira;
use App\UsersGrupos;
use App\Grupo;
use App\Curso;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\DB;
use Auth;


class PerfilController extends Controller
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
        return view('perfil.perfil');
    }


    public function perfilDocente (Request $request , int $tab = 1){
        $user = Auth::user()->getUser();
        $disciplinas = UserCadeira::join('cadeiras', 'users_cadeiras.cadeira_id', '=', 'cadeiras.id')->where('users_cadeiras.user_id', $user->id)->get();
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
        $utilizadores = User::get();

        $active_tab = $tab;


        $cursos = Curso::where('departamento_id', $request->departamento_id)->orderBy('nome')->get();


        return view ('perfil.perfil', compact('user', 'disciplinas', 'cadeiras','projetos', 'utilizadores', 'active_tab', 'cursos'));
    }


    public function changeNome(Request $request){
        $user = Auth::user()->getUser();
        $novoNome = $_POST['nome'];
        User::where('id',$user->id)->update(['nome'=>$novoNome]);
        return redirect()->action('PerfilController@perfilDocente');
    }

    public function changeEmail(Request $request){
        $user = Auth::user()->getUser();
        $novoEmail = $_POST['email'];
        $email = User::where('email', 'like', '%'.$novoEmail.'%')->first();

        if($email == null){
        User::where('id',$user->id)->update(['email'=>$novoEmail]);
        }
        else{
            //dá erro
        }
        return redirect()->action('PerfilController@perfilDocente');
        
    }

    public function changePass(Request $request){
        $user = Auth::user()->getUser();
        $oldPass = bcrypt($_POST['old_pass']);
        $novaPass = bcrypt($_POST['nova_pass']);
        $novaPass2 = bcrypt($_POST['nova_pass2']);
        
        print_r($user->password. '||||');
        print_r($oldPass.'||||');
        print_r($novaPass.'||||');
        print_r($novaPass2);
        if($user->password == $oldPass){
            
            if($oldPass == $novaPass){
                //dá erro
               
            }
            elseif($novaPass == $novaPass2){
                error_log('update');
                User::where('id',$user->id)->update(['password'=>$novaPass]);
            }
        }
        else{
            //dá erro
        }
        // f (password_verify('wegroup', $hash)) {
        //     echo 'Password is valid!';
        // } else {
        //     echo 'Invalid password.';
        // }

        //return redirect()->action('PerfilController@perfilDocente');
    }
    
}