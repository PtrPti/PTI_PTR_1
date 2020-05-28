<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
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

    //Chat aluno 

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
        // error_log($messages);

        $data = array(
            'messages'  => $messages,
        );

        $returnHTML = view('aluno.messages')->with($data)->render();
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
        $data->id_read = 0; // message will be unread when sending message
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

        // return response()->json(['message' => $message] );
    }




}
