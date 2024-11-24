<?php

namespace App\Controller;

use App\Entity\Chatbot;
use App\Form\ChatbotType;
use App\Repository\ChatbotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/chatbot')]
final class ChatbotController extends AbstractController{
    #[Route(name: 'app_chatbot_index', methods: ['GET'])]
    public function index(ChatbotRepository $chatbotRepository): Response
    {
        return $this->render('chatbot/index.html.twig', [
            'chatbots' => $chatbotRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_chatbot_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $chatbot = new Chatbot();
        $form = $this->createForm(ChatbotType::class, $chatbot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($chatbot);
            $entityManager->flush();

            return $this->redirectToRoute('app_chatbot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chatbot/new.html.twig', [
            'chatbot' => $chatbot,
            'form' => $form,
        ]);
    }

    #[Route('/{Id_Chatbot}', name: 'app_chatbot_show', methods: ['GET'])]
    public function show(Chatbot $chatbot): Response
    {
        return $this->render('chatbot/show.html.twig', [
            'chatbot' => $chatbot,
        ]);
    }

    #[Route('/{Id_Chatbot}/edit', name: 'app_chatbot_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chatbot $chatbot, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChatbotType::class, $chatbot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_chatbot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chatbot/edit.html.twig', [
            'chatbot' => $chatbot,
            'form' => $form,
        ]);
    }

    #[Route('/{Id_Chatbot}', name: 'app_chatbot_delete', methods: ['POST'])]
    public function delete(Request $request, Chatbot $chatbot, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chatbot->getId_Chatbot(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($chatbot);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_chatbot_index', [], Response::HTTP_SEE_OTHER);
    }
}
