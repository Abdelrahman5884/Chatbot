<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Newchat;
use Illuminate\Http\Request;

class NewChatController extends Controller
{
    public function index()
    {
        $newchats = Newchat::where('user_id', auth()->id())->with('chats')->get();
        return response()->json(['status' => true, 'data' => $newchats]);
    }

    public function store(Request $request)
    {
        $newchat = Newchat::create([
            'title' => $request->title ?? 'New Chat',
            'user_id' => auth()->id(),
        ]);

        return response()->json(['status' => true, 'data' => $newchat]);
    }

    public function show($id)
    {
        $newchat = Newchat::with('chats')->findOrFail($id);
        return response()->json(['status' => true, 'data' => $newchat]);
    }

    public function destroy($id)
    {
        $newchat = Newchat::findOrFail($id);
        $newchat->delete();
        return response()->json(['status' => true, 'message' => 'New chat deleted']);
    }
}
