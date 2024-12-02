<?php

namespace App\Controller;

use App\Entity\Forum;
use App\Form\ForumType;
use App\Repository\ForumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;

#[Route('/forum')]
final class ForumController extends AbstractController
{
    
    #[Route('/', name: 'app_forum_index', methods: ['GET'])]
    public function index(Request $request, ForumRepository $forumRepository)
    {
        $query = $request->query->get('query');  // Get the search query from the URL

        // If a query is provided, filter the forums based on it
        if ($query) {
            $forums = $forumRepository->searchForums($query);
        } else {
            $forums = $forumRepository->findAll();
        }

        return $this->render('forum/index.html.twig', [
            'forums' => $forums,
        ]);
    }

    #[Route('/forum', name: 'app_forum_front_index')]
public function indexFront(ForumRepository $forumRepository, Request $request): Response
{
    $query = $request->query->get('query', ''); // Get the search query from the request (defaults to empty string)
    
    // If a query is provided, search the forums
    if ($query) {
        $forums = $forumRepository->searchForums($query);
    } else {
        // Otherwise, get all forums
        $forums = $forumRepository->findAll();
    }

    // Generate a random color for each forum
    foreach ($forums as $forum) {
        $forum->randomColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF)); // Random hex color
    }

    return $this->render('forum/index2.html.twig', [
        'forums' => $forums,  // Pass forums to the view
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
            // The form data is already bound to the $forum object, so no need to call $form->getData() again.
            
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
    

    
    #[Route('/forum/{idForum}', name: 'app_forum_front_show', methods: ['GET'])]
    public function showFront(Forum $forum): Response
    {
        return $this->render('forum/show2.html.twig', [
            'forum' => $forum,
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



}
