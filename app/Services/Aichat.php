<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Aichat
{
    protected string $apikey;
    protected string $baseurl;

    public function __construct()
    {
        $this->apikey = config('services.groq.apikey') ?? '';
        $this->baseurl = config('services.groq.baseurl') ?? '';
    }

    public function chat(string $message): string
    {
        if (empty($this->apikey) || empty($this->baseurl)) {
            throw new \Exception("API key or Base URL not configured properly.");
        }

        $response = Http::withToken($this->apikey)
            ->post($this->baseurl . '/chat/completions', [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    ['role' => 'user', 'content' => $message]
                ],
            ]);

        if ($response->failed()) {
            throw new \Exception("AI API error: " . $response->body());
        }

        return $response->json('choices.0.message.content');
    }
}
