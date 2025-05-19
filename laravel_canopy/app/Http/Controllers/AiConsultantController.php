<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AiConsultantService;
use App\Models\AiChat;

class AiConsultantController extends Controller
{
    protected $ai;

    public function __construct(AiConsultantService $ai)
    {
        $this->ai = $ai;
    }

    public function chat(Request $request)
    {
        // return 123;
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $prompt = $request->input('message');
        $reply  = $this->ai->ask($prompt);

        // Сохраняем в БД
        AiChat::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'user_message' => $prompt,
            'bot_reply'    => $reply,
        ]);
        return response()->json([
            'reply' => $reply,
        ]);
    }
}
