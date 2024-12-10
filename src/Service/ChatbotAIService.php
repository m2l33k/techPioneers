<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ChatbotAIService
{
    private $httpClient;
    private $huggingFaceApiKey;

    // Inject HttpClientInterface here
    public function __construct(HttpClientInterface $httpClient, ParameterBagInterface $params)
{
    $this->httpClient = $httpClient;
    $this->huggingFaceApiKey = $params->get('huggingface_api_key');

    // Debugging the value
      // This should print the value of the API key
}



    public function askAI(string $prompt): string
    {
        $response = $this->httpClient->request('POST', 'https://api-inference.huggingface.co/models/microsoft/DialoGPT-small', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->huggingFaceApiKey,  // Ensure the correct API key is provided
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'inputs' => $prompt,  // The user's prompt
            ],
        ]);

        // Handle response here (parse, log, or return as needed)
        return $response->getContent();  // Or other methods to handle the response
    }
}
