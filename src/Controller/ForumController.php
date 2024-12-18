<?php

namespace App\Controller;

use App\Entity\Forum;
use App\Form\ForumType;
use App\Repository\ForumRepository;
use App\Repository\MessageForumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\MessageForum; 
use Symfony\Component\HttpFoundation\JsonResponse;




#[Route('/forum')]
final class ForumController extends AbstractController
{
    
    #[Route('/', name: 'app_forum_index', methods: ['GET'])]
    public function index(Request $request, ForumRepository $forumRepository)
    {
        $query = $request->query->get('query');  

        if ($query) {
            $forums = $forumRepository->searchForumsByQuery($query);
        } else {
            $forums = $forumRepository->findAll();
        }

        return $this->render('forum/index.html.twig', [
            'forums' => $forums,
        ]);
    }

    #[Route('/forum', name: 'app_forum_front_index')]
public function indexFront(ForumRepository $forumRepository, UserRepository $userRepository, Request $request): Response
{
    $query = $request->query->get('query', '');  
    $creatorId = $request->query->get('creator'); 
    $sortByDate = $request->query->get('sortByDate'); 
    $sortByActivity = $request->query->get('sortByActivity'); 

  
    $creatorId = $creatorId ? (int) $creatorId : null;

    if (!empty($query)) {
       
        $forums = $forumRepository->searchForumsByQuery($query);
    } else {
        
        $forums = $forumRepository->filterForums($creatorId, $sortByDate, $sortByActivity);
    }

    // Generate a random color for each forum
    foreach ($forums as $forum) {
        $forum->randomColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF)); // Random hex color
    }

    $users = $userRepository->findAll();

    return $this->render('forum/index2.html.twig', [
        'forums' => $forums,
        'users' => $users,
    ]);
}


    

    


#[Route('/new', name: 'app_forum_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
{
    $forum = new Forum();
    $users = $userRepository->findAll();

    // Create and handle the form
    $form = $this->createForm(ForumType::class, $forum);
    $form->handleRequest($request);

    // Check if the form was submitted and is valid
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($forum);
        $entityManager->flush(); // Persist to the database

        // Redirect to the forum list after successful creation
        return $this->redirectToRoute('app_forum_index');
    }

    // Render the form with the list of users
    return $this->render('forum/new.html.twig', [
        'forum' => $forum,
        'form' => $form->createView(),
        'users' => $users,
    ]);
}

    #[Route('/forum/new', name: 'app_forum_front_new', methods: ['GET', 'POST'])]
    public function newFront(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $forum = new Forum();
        $users = $userRepository->findAll();
    
        // Create and handle the form
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);
    
        // Check if the form was submitted and is valid
        if ($form->isSubmitted() && $form->isValid()) {
            // The form data is already bound to the $forum object, so no need to call $form->getData() again.
            
            $entityManager->persist($forum);
            $entityManager->flush(); // Persist to the database
    
            // Redirect to the forum list after successful creation
            return $this->redirectToRoute('app_forum_front_index');
        }
    
        // Render the form with the list of users
        return $this->render('forum/new2.html.twig', [
            'forum' => $forum,
            'form' => $form->createView(),
            'users' => $users,
        ]);
    }
    
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    
    #[Route('/forum/{idForum}', name: 'app_forum_front_show', methods: ['GET'])]
    public function showFront(Forum $forum, MessageForumRepository $messageForumRepository): Response
    {
        // Retrieve the search term from the query parameters
    $search = $this->requestStack->getCurrentRequest()->query->get('search', null);

    // Use the search term to filter messages by forum ID and search query
    $messages = $messageForumRepository->searchByForumAndQuery($forum, $search);

    // Render the forum page with the messages and search term
    return $this->render('forum/show2.html.twig', [
        'forum' => $forum,
        'search' => $search,
        'messages' => $messages,
    ]);
    }

    
    #[Route('/{idForum}', name: 'app_forum_show', methods: ['GET'])]
    public function show(Forum $forum): Response
    {
        return $this->render('forum/show.html.twig', [
            'forum' => $forum,
        ]);
        
    }

    #[Route('/{idForum}/edit', name: 'app_forum_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Forum $forum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('app_forum_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('forum/edit.html.twig', [
            'form' => $form->createView(), // Pass the form view to the template
            'forum' => $forum,
        ]);
    }
    

    #[Route('/{idForum}', name: 'app_forum_delete', methods: ['POST'])]
    public function delete(Request $request, Forum $forum, EntityManagerInterface $entityManager): Response
    {
        if (true) { // Bypass CSRF token check for now
            $entityManager->remove($forum);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('app_forum_index', [], Response::HTTP_SEE_OTHER);
    }



    #[Route('/message/edit/{id}', name: 'edit_message_forum', methods: ['POST'])]
public function editMessage(Request $request, MessageForum $message, EntityManagerInterface $em)
{
    // Ensure the message exists
    if (!$message) {
        return new JsonResponse(['error' => 'Message not found'], 404);
    }

    // Get the new content from the request
    $newContent = $request->request->get('content');

    // Check if content is provided
    if (!$newContent) {
        return new JsonResponse(['error' => 'No content provided'], 400);
    }

    // Update the message content
    $message->setConetenuIdMessageForum($newContent);

    // Persist the changes to the database
    $em->flush();

    // Return the updated message as a JSON response
    return new JsonResponse(['updatedMessage' => $newContent]);
}
public function showForum(Request $request, Forum $forum): Response
{
    $search = $request->query->get('search', ''); // Get the 'search' parameter
    $messages = $this->getDoctrine()
                     ->getRepository(Message::class)
                     ->findBy(['forum' => $forum]); // Replace with your logic for fetching messages

    // Filter messages if 'search' is provided
    if ($search) {
        $messages = array_filter($messages, function ($message) use ($search) {
            return stripos($message->getContent(), $search) !== false;
        });
    }

    return $this->render('forum/show2.html.twig', [
        'forum' => $forum,
        'search' => $search,
        'messages' => $messages,
    ]);
}

}

