<?php

namespace App\Http\Controllers;

use App\Notifications\ChatMessage;
use Auth;
use Illuminate\Http\Request;
use Notification;

class ChatMessagesController extends Controller
{
    public function store(Request $request)
    {
//        event(new ChatMessage($request->body));

        Notification::send(Auth::user(),new ChatMessage($request->body));
    }
}
