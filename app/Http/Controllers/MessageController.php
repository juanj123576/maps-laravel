<?php

namespace App\Http\Controllers;

use App\Events\MessageSentEvent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function fetch()
    {
        return Message::with('user')->get();
    }

    public function sentMessage(Request $request)
    {

        $user = Auth::user();

        $message = Message::create([
            'message' => $request->message,
            'user_id' => $user->id,
        ]);

        event(new MessageSentEvent($user, $message));

    }
}
