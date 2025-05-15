<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AiConsultantService
{
    protected $endpoint;
    protected $apiKey;

    public function __construct()
    {
        $this->endpoint = config('services.gemini.endpoint');
        $this->apiKey   = config('services.gemini.key');
    }

    /**
     * Отправляет запрос в Gemini и возвращает текст ответа.
     *
     * @param  string  $prompt
     * @return string
     */
    // app/Services/AiConsultantService.php
    public function ask(string $prompt): string
    {
        $endpoint = config('services.gemini.endpoint');
        $apiKey   = config('services.gemini.key');
        $url      = "{$endpoint}?key={$apiKey}";
        $host     = parse_url($endpoint, PHP_URL_HOST);

        $response = Http::withOptions([
                'verify' => storage_path('certs/cacert.pem'),
            ])
            ->withHeaders([
                'Host'         => $host,
                'Content-Type' => 'application/json',
            ])
            ->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'temperature'     => 0.7,
                    // можно добавить topP, topK, maxOutputTokens и т.д.
                ],
            ]);

        if ($response->failed()) {
            \Log::error('Gemini API error', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            throw new \RuntimeException('Ошибка при обращении к AI-сервису');
        }

        $data = $response->json();

        // Правильный путь к сгенерированному тексту:
        if (!empty($data['candidates'][0]['content']['parts'][0]['text'])) {
            return $data['candidates'][0]['content']['parts'][0]['text'];
        }

        return 'Извините, я не смог сформулировать ответ.';
    }

}
