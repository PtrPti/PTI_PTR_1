<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserInfo;
use App\Projeto;
use App\UserCadeira;
use App\UsersGrupos;
use App\Message;
use Illuminate\Support\Facades\DB;
use Auth;
use DateTime;
use Pusher\Pusher;


class ChatController extends Controller
{
    public static function getUsers($grupos_ids, $cadeira_ids, $user_id, $search = "") {        
        if (sizeof($grupos_ids) == 0) {
            $grupos = 0;
        }
        else {
            $grupos = implode(",", $grupos_ids);
        }

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
            left join users_grupos ug
                on u.id = ug.user_id
                and ug.grupo_id in (:grupos)
            inner join users_cadeiras uc
                on u.id = uc.user_id
                and uc.cadeira_id in (:cadeiras)
                and u.perfil_id = 2
            left join  messages m
                on u.id = m.from
                and id_read = 0 
                and m.to = :u1
            left join (select * from messages order by created_at desc) as m2
                on (m2.from = :u2 and m2.to = u.id)
                or (m2.to = :u3 and m2.from = u.id)
            where u.id != :u4 ". $search .
            " group by u.id, u.nome, u.email"), ['grupos' => $grupos, 'cadeiras' => implode(",", $cadeira_ids), 'u1' => $user_id, 'u2' => $user_id, 'u3' => $user_id, 'u4' => $user_id]
        );
        
        return $utilizadores;
    }

    public static function getUsersDocente($cadeiras_id, $user_id, $departamento_id, $search = "") {
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
            inner join users_info ui
                on u.id = ui.user_id
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
            where u.id != :u4 and ui.departamento_id = :d " . $search .
            " group by u.id, u.nome, u.email"), ['cadeiras' => implode(",", $cadeiras_id), 'u1' => $user_id, 'u2' => $user_id, 'u3' => $user_id, 'u4' => $user_id, 'd' => $departamento_id]
        );
        
        return $utilizadores;
    }

    public function getUsersView() {
        $user = Auth::user()->getUser();
        $search = "and u.nome like '%" . $_GET["search"] . "%'";

        $grupos = UsersGrupos::where('user_id', $user->id)->select('grupo_id')->get();
        $cadeiras = UserCadeira::where('user_id', $user->id)->select('cadeira_id')->get();

        $grupos_ids = [];

        foreach($grupos as $g) {
            array_push($grupos_ids, $g->grupo_id);
        }

        $cadeira_ids = [];

        foreach($cadeiras as $g) {
            array_push($cadeira_ids, $g->cadeira_id);
        }

        $utilizadores = $this->getUsers($grupos_ids, $cadeira_ids, $user->id, $search);

        $data = array(
            'utilizadores' => $utilizadores
        );

        $returnHTML = view('layouts.chat.users')->with($data)->render();
        return response()->json(['html' => $returnHTML]);
    }

    public function getUsersViewDocente() {
        $user = Auth::user()->getUser();
        $departamento = User::join('users_info', 'users.id', '=', 'users_info.user_id')->where('users.id', $user->id)->first();
        $search = "and u.nome like '%" . $_GET["search"] . "%'";

        $cadeiras = UserCadeira::where('user_id', $user->id)->select('cadeira_id')->get();

        $cadeira_ids = [];

        foreach($cadeiras as $g) {
            array_push($cadeira_ids, $g->cadeira_id);
        }

        $utilizadores = $this->getUsersDocente($cadeira_ids, $user->id, $departamento->departamento_id, $search);

        $data = array(
            'utilizadores' => $utilizadores
        );

        $returnHTML = view('layouts.chat.users')->with($data)->render();
        return response()->json(['html' => $returnHTML]);
    }

    public function getMessage($user_id) {    
        $my_id = Auth::id();

        // Make read all unread message
        Message::where(['from' => $user_id, 'to' => $my_id])->update(['id_read' => 1]);       

         // Get all message from selected user
        $messages = Message::where(function ($query) use ($user_id, $my_id) {
                                        $query->where('from', $user_id)->where('to', $my_id);
                                    })->oRwhere(function ($query) use ($user_id, $my_id) {
                                        $query->where('from', $my_id)->where('to', $user_id);
                                    })->orderBy('created_at', 'asc')->get(); 

        $data = array(
            'messages'  => $messages,
        );

        $returnHTML = view('layouts.chat.messages')->with($data)->render();
        return response()->json(['html' => $returnHTML]);
    }

    public function sendMessage(Request $request) {
        $from = Auth::id();
        $to = $request->receiver_id;
        $message = $request->message;

        $data = new Message();
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->id_read = 0;
        $data->save();

        // pusher
        $options = array(
            'cluster' => 'eu',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['from' => $from, 'to' => $to]; // sending from and to user id when pressed enter
        $pusher->trigger('my-channel', 'my-event', $data);

        return redirect()->action('ChatController@getMessage', ['user_id' => $to]);
    }
}