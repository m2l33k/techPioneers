<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ChatbotAIService;

#[Route('/chatbot')]
final class ChatbotController extends AbstractController
{
    #[Route('/conversation', name: 'chatbot_conversation', methods: ['GET', 'POST'])]
    public function conversation(Request $request, ChatbotAIService $aiService): Response
    {
        $messages = [];

        if ($request->isMethod('POST')) {
            $userMessage = $request->request->get('question');
            
            // Get raw response from AI service
            $botResponseRaw = $aiService->askAI($userMessage);

            // Parse and clean up the AI response
            $botResponseArray = json_decode($botResponseRaw, true);
            $botResponse = $botResponseArray[0]['generated_text'] ?? 'Sorry, I could not understand that.';

            // Add user and bot messages to the chat history
            $messages[] = ['content' => "👤 $userMessage"];
            $messages[] = ['content' => "🤖 $botResponse"];
        }

        return $this->render('chatbot/conversation.html.twig', [
            'messages' => $messages,
        ]);
    }
}
