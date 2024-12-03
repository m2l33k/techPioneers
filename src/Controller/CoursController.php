<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use App\Repository\CoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cours')]
final class CoursController extends AbstractController
{
    #[Route(name: 'app_cours_index', methods: ['GET'])]
    public function index(CoursRepository $coursRepository): Response
    {
        return $this->render('cours/index.html.twig', [
            'cours' => $coursRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cours_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cour = new Cours();
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cour);
            $entityManager->flush();

            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cours/new.html.twig', [
            'cour' => $cour,
            'form' => $form,
        ]);
    }

    #[Route('/{Id_Cours}', name: 'app_cours_show', methods: ['GET'])]
    public function show(Cours $cour): Response
    {
        return $this->render('cours/show.html.twig', [
            'cour' => $cour,
           /* 'isBackoffice' => true,*/ 
        ]);
    }

    #[Route('/{Id_Cours}/edit', name: 'app_cours_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cours $cour, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            // Ajout d'un message flash
        $this->addFlash('success', 'Le cours a été modifié avec succès.');

            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cours/edit.html.twig', [
            'cour' => $cour,
            'form' => $form,
        ]);
    }

    #[Route('/{Id_Cours}', name: 'app_cours_delete', methods: ['POST'])]
    public function delete(Request $request, Cours $cour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cour->getIdCours(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($cour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
    }
    // Affiche les ressources liées à un cours
    #[Route('/{Id_Cours}/ressources', name: 'app_cours_ressources', methods: ['GET'])]
    public function showRessources(int $Id_Cours, RessourceRepository $ressourceRepository): Response
    {
        // Récupérer le cours par son ID
        $cours = $this->getDoctrine()->getRepository(Cours::class)->find($Id_Cours);
        
        // Vérifier si le cours existe
        if (!$cours) {
            throw $this->createNotFoundException('Le cours demandé n\'existe pas.');
        }

        // Récupérer toutes les ressources liées au cours
        $ressources = $ressourceRepository->findBy(['Id_Cours' => $cours]);

        // Retourner la vue avec les ressources
        return $this->render('cours/ressources.html.twig', [
            'cours' => $cours,
            'ressources' => $ressources,
        ]);
    }
    #[Route('app_cours_index2', methods: ['GET'])]
    public function index2(CoursRepository $coursRepository): Response
    {
        return $this->render('cours/index2.html.twig', [
            'cours' => $coursRepository->findAll(),
        ]);
    }
   
   #[Route('/front/{Id_Cours}', name: 'app_cours_show2', methods: ['GET'])]
    public function show2(Cours $cour): Response
    {
      
        return $this->render('cours/show2.html.twig', [
            'cour' => $cour,
        
            /*'isBackoffice' => false,*/ 
        ]);
    }
   
   
}
