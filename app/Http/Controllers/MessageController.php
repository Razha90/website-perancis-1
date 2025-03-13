<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        Log::info("Masuk ke sendMessage", ['data' => $request->all(), 'sender_id' => Auth::id()]);
        // dump("Masuk ke sendMessage", $request->all());

        $request->validate([
            'receiver_id' => 'required|exists:users,id|not_in:' . Auth::id(),
            'message' => 'required|string',
        ]);



        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);


        event(new MessageSent($message));

        return response()->json(['message' => 'Pesan terkirim', 'data' => $message]);
    }

    public function getMessages($userId)
    {
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', Auth::id())->where('receiver_id', $userId);
        })
            ->orWhere(function ($query) use ($userId) {
                $query->where('receiver_id', Auth::id())->where('sender_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->paginate(20); // Menggunakan pagination

        return response()->json($messages);


    }

}


