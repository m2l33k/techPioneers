<?php

namespace App\Controller;

use App\Entity\Ressource;
use App\Form\RessourceType;
use App\Repository\RessourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ressource')]
final class RessourceController extends AbstractController
{
    #[Route(name: 'app_ressource_index', methods: ['GET'])]
    public function index(RessourceRepository $ressourceRepository,Request $request): Response
    {
      // Récupère le paramètre de recherche du titre de la ressource
      $titreRessource = $request->query->get('titreRessource');

      // Si un titre est fourni, effectue la recherche
      if ($titreRessource) {
          $ressources = $ressourceRepository->findByTitreRessource($titreRessource);
      } else {
          $ressources = $ressourceRepository->findAll();  // Sinon, récupère toutes les ressources
      }
    $this->denyAccessUnlessGranted('ROLE_STUDENT');
      return $this->render('ressource/index.html.twig', [
          'ressources' => $ressources,
      ]);
    }

    #[Route('/new', name: 'app_ressource_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ressource = new Ressource();
        $form = $this->createForm(RessourceType::class, $ressource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $entityManager->persist($ressource);
            $entityManager->flush();
            $this->denyAccessUnlessGranted('ROLE_STUDENT');
            return $this->redirectToRoute('app_ressource_index', [], Response::HTTP_SEE_OTHER);
        }
        

        return $this->render('ressource/new.html.twig', [
            'ressource' => $ressource,
            'form' => $form,
        ]);
    }

    #[Route('/{Id_Ressource}', name: 'app_ressource_show', methods: ['GET'])]
    public function show(Ressource $ressource): Response
    {
      $this->denyAccessUnlessGranted('ROLE_STUDENT');
        return $this->render('ressource/show.html.twig', [
            'ressource' => $ressource,
        ]);
    }

    #[Route('/{Id_Ressource}/edit', name: 'app_ressource_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ressource $ressource, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RessourceType::class, $ressource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ressource_index', [], Response::HTTP_SEE_OTHER);
        }
        $this->denyAccessUnlessGranted('ROLE_STUDENT');
        return $this->render('ressource/edit.html.twig', [
            'ressource' => $ressource,
            'form' => $form,
        ]);
    }

    #[Route('/{Id_Ressource}', name: 'app_ressource_delete', methods: ['POST'])]
    public function delete(Request $request, Ressource $ressource, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ressource->getIdRessource(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ressource);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ressource_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/student/ressources', name: 'student_ressource_index', methods: ['GET'])]
    public function index2(RessourceRepository $ressourceRepository, Request $request): Response
    {
        $titreRessource = $request->query->get('titreRessource');
    
        $ressources = $titreRessource 
            ? $ressourceRepository->findByTitreRessource($titreRessource) 
            : $ressourceRepository->findAll();
            $this->denyAccessUnlessGranted('ROLE_STUDENT');
        return $this->render('ressource/index2.html.twig', [
            'ressources' => $ressources,
        ]);
    }
}
