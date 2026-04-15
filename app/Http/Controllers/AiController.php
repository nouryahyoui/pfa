<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiController extends Controller
{
    public function traduire(Request $request)
    {
        $texte = $request->texte;
        $langue = $request->langue;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => "Traduis ce texte en $langue. Retourne SEULEMENT la traduction, sans explication : $texte"
                ]
            ],
            'max_tokens' => 1024,
        ]);

        $data = $response->json();
        $traduction = $data['choices'][0]['message']['content'] ?? 'Erreur de traduction';

        return response()->json(['traduction' => $traduction]);
    }

    public function chatbot(Request $request)
    {
        $message = $request->message;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "Tu es un assistant virtuel pour une plateforme d'annonces en ligne. Tu aides les utilisateurs à publier des annonces, trouver des produits, et naviguer sur le site. Réponds toujours en français de manière courte et utile."
                ],
                [
                    'role' => 'user',
                    'content' => $message
                ]
            ],
            'max_tokens' => 512,
        ]);

        $data = $response->json();
        $reponse = $data['choices'][0]['message']['content'] ?? 'Désolé, je ne peux pas répondre maintenant.';

        return response()->json(['reponse' => $reponse]);
    }
}