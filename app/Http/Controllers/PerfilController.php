<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Projeto;
use App\UserCadeira;
use App\UsersGrupos;
use App\Grupo;
use App\Curso;
use App\UserInfo;
use App\AvaliacaoMembros;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Storage;
use Auth;
use Image;


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
        $user_info = User::join('users_info', 'users.id', '=', 'users_info.user_id')->where('users.id', $user->id)->first();
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

        $utilizadores = User::join('users_info', 'users.id', '=', 'users_info.user_id')->where('users.id', $user->id)->get();

        $active_tab = $tab;

        $cursos = Curso::where('departamento_id', $request->departamento_id)->orderBy('nome')->get();

        $user_info = UserInfo::join('users', 'users_info.user_id', '=', 'users.id')->where('users.id', $user->id)->first();

        $lista_alunos = UserCadeira::join('users', 'users_cadeiras.user_id', '=', 'users.id')->join('users_info', 'users.id', '=', 'users_info.user_id')->
                            where('users_cadeiras.cadeira_id', $user->id)->
                            where('users.perfil_id', 1)->get();

      
        $resultados = DB::select(DB::raw('select avg(nota) as nota, p.nome from avaliacao_membros am
                                            join grupos g
                                            on am.grupo_id = g.id
                                            join projetos p
                                            on g.projeto_id = p.id
                                            where membro_avaliado = ? group by am.grupo_id'), [$user->id]);

        if ($user->avatar == null){
          $avatar= Storage::disk('s3')->url('images/default.png');
        }else{
          $avatar = Storage::disk('s3')->url($user->avatar);
        }

        return view ('perfil.perfil', compact('user', 'user_info','disciplinas', 'cadeiras','projetos', 'utilizadores', 'active_tab', 'cursos', 'lista_alunos', 'resultados', 'projetos_avaliacao'));        
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

        $novaPass = bcrypt($_POST['nova_pass']);
        /* $oldPass = bcrypt($_POST['old_pass']);
        $novaPass = bcrypt($_POST['nova_pass']);
        $novaPass2 = bcrypt($_POST['nova_pass2']);
         */
  /*       print_r($user->password. '||||');
        print_r($oldPass.'||||');
        print_r($novaPass.'||||');
        print_r($novaPass2);
        if($user->password == $oldPass){

            if($oldPass == $novaPass){
                //dá erro

            }
            elseif($novaPass == $novaPass2){
                error_log('update'); */
                User::where('id',$user->id)->update(['password'=>$novaPass]);
         /*    }
        }
        else{ */
            //dá erro

        // f (password_verify('wegroup', $hash)) {
        //     echo 'Password is valid!';
        // } else {
        //     echo 'Invalid password.';
        // }

        return redirect()->action('PerfilController@perfilDocente');
    }

    public function updateAvatar(Request $request){

    	// Handle the user upload of avatar
    	if($request->hasFile('avatar')){
        $s3= Storage::disk("s3");
        $s3->delete(Auth::user()->avatar);
    		$avatar = $request->file('avatar');

            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $s3filepath = "images/" . $filename;
        $path= $s3 -> putFileAs('images', $avatar, $filename, 'public' );


        //Image::make()->resize(300, 300);
    		$user = Auth::user();
    		$user->avatar = $path;
    		$user->save();
    	}

    	return redirect()->action('PerfilController@perfilDocente');
    }
}