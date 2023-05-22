<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Models\Message as ModelsMessage;
use App\Models\User;
use Illuminate\Http\Request;

class Message extends Controller
{
    public function getMessages(Request $request)
    {
        $messages = ModelsMessage::where([['sender_id',$request->sender_id],['reciever_id', $request->reciever_id]])->orWhere([['sender_id', $request->reciever_id], ['reciever_id', $request->sender_id]])->get();
        return response()->json($messages);
    }

    public function getLastSeen(Request $request)
    {
        $lastseen = User::where('id',$request->reciever_id)->value('last_seen');
        $lastseen = \Carbon\Carbon::parse($lastseen)->diffForHumans();
        return response()->json($lastseen);
    }

    public function sendMessage(Request $request) 
    {
        event(new NewMessage($request->sender_id,$request->reciever_id,$request->message));
        $message = ModelsMessage::create([
            'sender_id' => $request->sender_id,
            'reciever_id' => $request->reciever_id,
            'message' => $request->message
        ]);

        return response()->json($message);

    }
}
