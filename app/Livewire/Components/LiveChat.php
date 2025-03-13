<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LiveChat extends Component
{
    public $messages = [];
    public $newMessage;

    public function mount()
    {
        // Cek apakah pesan sudah ada di session Livewire
        if (!session()->has('chat_messages')) {
            Log::info('Session tidak ada');

            $this->messages = Message::latest()->take(10)->get()->reverse();
            session(['chat_messages' => $this->messages]);
        } else {
            Log::info('Session ada');
            $this->messages = session('chat_messages');
        }
    }

    public function sendMessage($message)
    {
        Log::info('Mengirim pesan', ['message' => $message]);
        Log::info("Masuk ke sendMessage", ['data' => $message, 'sender_id' => Auth::id()]);
        $chatMessage = Message::create([
            'sender_id' => auth()->id(),
            'message' => $message,
            'receiver_id' => 2,
        ]);

        $this->messages[] = $chatMessage;

        // Simpan di session Livewire
        session(['chat_messages' => $this->messages]);
        event(new MessageSent($message));

        // $this->newMessage = '';

    }
    public function render()
    {
        return view('livewire.components.live-chat');
    }
}
