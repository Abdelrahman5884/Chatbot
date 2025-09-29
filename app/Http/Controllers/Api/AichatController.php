<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Aichat;
use App\Models\Chat;


class AichatController extends Controller
{
    protected Aichat $ai;

    public function __construct(Aichat $ai)
    {
        $this->ai = $ai;
    }

    public function chatbot(Request $request)
    {
        $data = $request->validate([
            'message' => 'required|string|max:4000'
        ]);

        $reply = $this->ai->chat($data['message']);

        Chat::create([
            'name' => $data['message'],
            'user_id' => auth()->id(),
            'prompt' => $data['message'],
            'response' => $reply,
        ]);

        return response()->json(['reply' => $reply]);
    }
    public function index()
    {
        if(auth()->id()== null ){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $chat = Chat::where('user_id', auth()->id())->get();
        return response()->json(['status' => true, 'data' => $chat]);
    }
    public function show($id)
    {
        $chat = Chat::find($id);
//        if(auth()->id()== $chat->user_id){
            return response()->json(['status' => true, 'data' => $chat]);
//        }
    }
    public function destroy($id)
    {
        $chat = Chat::find($id);
        $chat->delete();
        return response()->json(['status' => true ,'message' => 'message deleted']);
    }
}
