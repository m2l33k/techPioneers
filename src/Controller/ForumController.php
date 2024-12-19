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
use App\Form\MessageForumType;
use Symfony\Component\Security\Core\Security;





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
    
private EntityManagerInterface $entityManager;
    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
    }
    
    #[Route('/forum/{idForum}', name: 'app_forum_front_show', methods: ['GET'])]
public function showFront(Forum $forum, MessageForumRepository $messageForumRepository, Request $request, EntityManagerInterface $entityManager, Security $security): Response
{
    // Retrieve the search term from the query parameters
    $search = $this->requestStack->getCurrentRequest()->query->get('search', null);

    // Use the search term to filter messages by forum ID and search query
    $messages = $messageForumRepository->searchByForumAndQuery($forum, $search);

    // Create and handle the form for posting a message
    $message = new MessageForum();
    $message->setForum($forum);

    $user = $security->getUser();
    if (!$user) {
        throw $this->createAccessDeniedException('You must be logged in to post a message.');
    }

    $message->setCreateurMessageForum($user);
    $message->setDateCreationIdMessageForum(new \DateTime('now'));

    $form = $this->createForm(MessageForumType::class, $message);
    $form->handleRequest($request);

    // If the form is submitted and valid, persist the message
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($message);
        $entityManager->flush();

        return $this->redirectToRoute('app_forum_front_show', ['idForum' => $forum->getIdForum()]);
    }

    // Render the forum page with the messages and form
    return $this->render('forum/show2.html.twig', [
        'forum' => $forum,
        'search' => $search,
        'messages' => $messages,
        'form' => $form->createView(),  // Pass the form to the view
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
    // Check if the logged-in user is the creator of the forum post
    if ($this->getUser() !== $forum->getCreateurForum()) {
        // If not the creator, redirect to the forum index or show an error
        return $this->redirectToRoute('app_forum_index');
    }

    // Create the form and handle the request
    $form = $this->createForm(ForumType::class, $forum);
    $form->handleRequest($request);

    // If form is submitted and valid, save changes
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        // Redirect to the forum index page after successful edit
        return $this->redirectToRoute('app_forum_index', [], Response::HTTP_SEE_OTHER);
    }

    // Render the edit page with the form
    return $this->render('forum/edit.html.twig', [
        'form' => $form->createView(),
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



    #[Route('forum/{idForum}/message/{idMessageForum}/edit', name: 'edit_message_forum', methods: ['PUT'])]
public function editMessage(Request $request, Forum $forum, MessageForum $message, EntityManagerInterface $em): JsonResponse
{
    // Ensure the logged-in user is the creator of the message
    if ($message->getCreateurMessageForum() !== $this->getUser()) {
        return new JsonResponse(['error' => 'Unauthorized'], 403);
    }

    // Decode JSON content
    $newContent = json_decode($request->getContent(), true)['content'] ?? null;

    if (!$newContent) {
        return new JsonResponse(['error' => 'No content provided'], 400);
    }

    // Update the message
    $message->setConetenuIdMessageForum($newContent);
    $message->setDateCreationIdMessageForum(new \DateTime()); // Update the timestamp

    $em->flush();

    return new JsonResponse([
        'success' => true,
        'updatedMessage' => $newContent,
        'messageId' => $message->getIdMessageForum(),
    ]);
}

    

#[Route('forum/{idForum}/new', name: 'app_message_forum_new', methods: ['GET', 'POST'])]
public function newMessage(Request $request, EntityManagerInterface $entityManager, int $idForum, Security $security): Response
{
    $forum = $entityManager->getRepository(Forum::class)->find($idForum);

    if (!$forum) {
        throw $this->createNotFoundException('Forum not found.');
    }

    $message = new MessageForum();
    $message->setForum($forum);

    $user = $security->getUser();
    if (!$user) {
        throw $this->createAccessDeniedException('You must be logged in to post a message.');
    }

    $message->setCreateurMessageForum($user);
    $message->setDateCreationIdMessageForum(new \DateTime('now'));

    $form = $this->createForm(MessageForumType::class, $message);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($message);
        $entityManager->flush();

        return $this->redirectToRoute('app_forum_front_show', ['idForum' => $forum->getIdForum()]);
    }

    return $this->render('forum/show2.html.twig', [
        'form' => $form->createView(),
        'forum' => $forum,
    ]);
    
}

/*public function showForum(Request $request, Forum $forum): Response
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
}*/


/*

    public function newMessage(Request $request, Forum $forum): Response
    {
        $content = $request->request->get('messageContent');
        $user = $this->getUser();
    
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
    
        // Check if the content is provided
        if (empty($content)) {
            $this->addFlash('error', 'Message content cannot be empty.');
            return $this->redirectToRoute('app_forum_front_show', ['idForum' => $forum->getIdForum()]);
        }
    
        // Create a new MessageForum entity
        $message = new MessageForum();
        $message->setConetenuIdMessageForum($content); // Set content
        $message->setCreateurMessageForum($user); // Set creator
        $message->setForum($forum); // Set forum
        $message->setDateCreationIdMessageForum(new \DateTime()); // Set creation date
    
        // Persist and flush the entity
        $this->entityManager->persist($message);
        $this->entityManager->flush();
    
        // Redirect back to the forum show route
        return $this->redirectToRoute('app_forum_front_show', ['idForum' => $forum->getIdForum()]);
    }
    */
}



