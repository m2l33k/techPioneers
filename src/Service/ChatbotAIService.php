<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;




class ChatbotAIService
{
    private $httpClient;
    private $openaiApiKey;

    public function __construct(ParameterBagInterface $parameterBag)
{
    $this->openaiApiKey = $parameterBag->get('openai_api_key');  // Fetch from parameters
}
    public function askAI(string $prompt): string
    {
        $response = $this->httpClient->request('POST', 'https://api.openai.com/v1/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->openaiApiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'text-davinci-003',
                'prompt' => $prompt,
                'max_tokens' => 150,
            ],
        ]);

        $data = $response->toArray();

        return $data['choices'][0]['text'] ?? 'No response available.';
    }
}
