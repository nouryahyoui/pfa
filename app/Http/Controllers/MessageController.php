<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Annonce;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request, Annonce $annonce)
    {
        $request->validate([
            'contenu' => 'required|max:1000',
        ]);

        Message::create([
            'contenu' => $request->contenu,
            'annonce_id' => $annonce->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $annonce->user_id,
            'lu' => false,
        ]);

        return redirect()->back()->with('success', 'Message envoyé !');
    }

    public function index()
    {
        $messages = Message::where('receiver_id', auth()->id())
                    ->orWhere('sender_id', auth()->id())
                    ->with('sender', 'receiver', 'annonce')
                    ->latest()
                    ->get()
                    ->groupBy('annonce_id');

        return view('messages.index', compact('messages'));
    }

    public function conversation(Annonce $annonce)
    {
        $messages = Message::where('annonce_id', $annonce->id)
                    ->where(function($query) {
                        $query->where('sender_id', auth()->id())
                              ->orWhere('receiver_id', auth()->id());
                    })
                    ->with('sender', 'receiver')
                    ->oldest()
                    ->get();

        Message::where('annonce_id', $annonce->id)
                ->where('receiver_id', auth()->id())
                ->update(['lu' => true]);

        return view('messages.conversation', compact('messages', 'annonce'));
    }
}