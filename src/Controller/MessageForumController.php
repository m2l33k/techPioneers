<?php

namespace App\Controller;

use App\Entity\Forum;
use App\Entity\MessageForum;
use App\Form\MessageForumType;
use App\Repository\MessageForumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;


#[Route('/message/forum')]
final class MessageForumController extends AbstractController{
    
    #[Route('/', name: 'app_message_forum_index', methods: ['GET'])]
public function index(Request $request, MessageForumRepository $messageForumRepository): Response
{
    // Get the query parameter from the request
    $query = $request->query->get('query');
    
    // If there's a search query, filter the results based on that query
    if ($query) {
        $results = $messageForumRepository->searchByQuery($query);
    } else {
        // If there's no query, show all messages
        $results = $messageForumRepository->findAll();
    }

    // Return the results to the same page
    return $this->render('message_forum/index.html.twig', [
        'results' => $results,  // Pass the filtered results
    ]);
}
    

    #[Route('/{idForum}/new', name: 'app_message_forum_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $idForum, Security $security): Response
    {
        // Find the forum where the message will be added
        $forum = $entityManager->getRepository(Forum::class)->find($idForum); // Correct repository: Forum
    
        if (!$forum) {
            throw $this->createNotFoundException('Forum not found.');
        }
    
        // Create a new message associated with the forum
        $message = new MessageForum();
        $message->setForum($forum);  // Correctly setting the Forum entity
    
        // Get the logged-in user and set the creator of the message
        $user = $security->getUser(); // This gets the currently authenticated user
    
        // Check if the user is an instance of your custom User entity
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('You must be logged in to create a message.');
        }
    
        $message->setCreateurMessageForum($user);  // Set the user as the creator
    
        $message->setDateCreationIdMessageForum(new \DateTime());  // Set the creation date
    
        // Handle the form submission
        $form = $this->createForm(MessageForumType::class, $message);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($message);
            $entityManager->flush();
    
            // Redirect to the forum's chat page to display the new message
            return $this->redirectToRoute('app_message_forum_show', ['Id_MessageForum' => $message->getIdMessageForum()]);
        }
    
        return $this->render('message_forum/show2.html.twig', [
            'form' => $form->createView(),
            'forum' => $forum,  // Pass the forum object for context
        ]);
    }
    

   #[Route('/{idMessageForum}', name: 'app_message_forum_show', methods: ['GET'])]
public function show(int $idMessageForum, MessageForumRepository $messageForumRepository): Response
{
    $messageForum = $messageForumRepository->find($idMessageForum);
    
    if (!$messageForum) {
        throw new NotFoundHttpException('MessageForum not found.');
    }

    return $this->render('message_forum/show.html.twig', [
        'message_forum' => $messageForum,
    ]);
}


#[Route('/{id_message_forum}/edit', name: 'app_message_forum_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, EntityManagerInterface $em, int $id_message_forum)
{
    $message_forum = $em->getRepository(MessageForum::class)->find($id_message_forum);

    if (!$message_forum) {
        throw $this->createNotFoundException('No forum message found.');
    }

    $form = $this->createForm(MessageForumType::class, $message_forum);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();
        return $this->redirectToRoute('app_message_forum_index');
    }

    return $this->render('message_forum/edit.html.twig', [
        'message_forum' => $message_forum,
        'form' => $form->createView(),
    ]);
}

    

#[Route('/{IdMessageForum}', name: 'app_message_forum_delete', methods: ['POST'])]
public function delete(Request $request, int $IdMessageForum, MessageForumRepository $messageForumRepository, EntityManagerInterface $entityManager): Response
{
    // Step 1: Find the message to delete
    $messageForum = $messageForumRepository->find($IdMessageForum);

    // Step 2: Check if the message exists, throw exception if not found
    if (!$messageForum) {
        throw new NotFoundHttpException('MessageForum not found.');
    }

    // Step 3: Validate CSRF token
    $csrfToken = $request->request->get('_token');
    dump('Received CSRF Token: ' . $csrfToken);  // Dump received token
    dump('Generated CSRF Token: ' . 'delete' . $messageForum->getIdMessageForum());  // Dump expected token

    if (!$this->isCsrfTokenValid('delete' . $messageForum->getIdMessageForum(), $csrfToken)) {
        throw new \Exception('Invalid CSRF token');
    }

    // Step 4: Remove the message
    $entityManager->remove($messageForum);
    $entityManager->flush();

    // Step 5: Redirect after deletion
    return $this->redirectToRoute('app_message_forum_index', [], Response::HTTP_SEE_OTHER);
}

#[Route('/search', name: 'app_message_forum_search', methods: ['GET'])]
public function search(Request $request, MessageForumRepository $messageForumRepository): Response
{
    // Get the query parameter from the request
    $query = $request->query->get('query');
    
    // Ensure the query is an integer if it's meant to be an ID
    $query = is_numeric($query) ? (int)$query : $query;

    // Perform the search based on the query (you may need to adapt this in your repository)
    $results = $messageForumRepository->searchByQuery($query);

    // Return the results to the view
    return $this->render('message_forum/index.html.twig', [
        'results' => $results,
    ]);
}




}
