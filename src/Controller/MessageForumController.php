<?php

namespace App\Controller;

use App\Entity\MessageForum;
use App\Form\MessageForumType;
use App\Repository\MessageForumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/message/forum')]
final class MessageForumController extends AbstractController{
    #[Route('/', name: 'app_message_forum_index', methods: ['GET'])]
    public function index(MessageForumRepository $messageForumRepository): Response
    {
        return $this->render('message_forum/index.html.twig', [
            'message_forums' => $messageForumRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_message_forum_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $messageForum = new MessageForum();
        $form = $this->createForm(MessageForumType::class, $messageForum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($messageForum);
            $entityManager->flush();

            return $this->redirectToRoute('app_message_forum_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('message_forum/new.html.twig', [
            'message_forum' => $messageForum,
            'form' => $form,
        ]);
    }

    #[Route('/{Id_MessageForum}', name: 'app_message_forum_show', methods: ['GET'])]
    public function show(MessageForum $messageForum): Response
    {
        return $this->render('message_forum/show.html.twig', [
            'message_forum' => $messageForum,
        ]);
    }

    #[Route('/{Id_MessageForum}/edit', name: 'app_message_forum_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MessageForum $messageForum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MessageForumType::class, $messageForum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_message_forum_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('message_forum/edit.html.twig', [
            'message_forum' => $messageForum,
            'form' => $form,
        ]);
    }

    #[Route('/{Id_MessageForum}', name: 'app_message_forum_delete', methods: ['POST'])]
    public function delete(Request $request, MessageForum $messageForum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$messageForum->getId_MessageForum(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($messageForum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_message_forum_index', [], Response::HTTP_SEE_OTHER);
    }
}
