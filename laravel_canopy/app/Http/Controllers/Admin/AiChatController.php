<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AiChat;

class AiChatController extends Controller
{
    public function index(Request $request)
    {
        $chats = AiChat::latest()->paginate(20);
        return view('admin.ai_chats.index', compact('chats'));
    }

    public function show($id)
    {
        $chat = AiChat::findOrFail($id);
        return view('admin.ai_chats.show', compact('chat'));
    }
}
