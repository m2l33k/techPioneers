<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\Evenement1Type;
use App\Form\EvenementSearchType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
//import UrlGeneratorInterface

#[Route('/evenement')]
final class EvenementController extends AbstractController
{
  #[Route('/evenements/manage', name: 'app_evenement_manage', methods: ['GET', 'POST'])]
public function manage(Request $request, EvenementRepository $evenementRepository): Response
{
    // Same logic for teachers
    $form = $this->createForm(EvenementSearchType::class);
    $form->handleRequest($request);

    $evenements = $evenementRepository->findAll();

    if ($form->isSubmitted() && $form->isValid()) {
        $criteria = $form->getData();
        $evenements = $evenementRepository->search($criteria);
    }

    return $this->render('evenement/index.html.twig', [
        'form' => $form->createView(),
        'evenements' => $evenements,
    ]);
}

#[Route('/evenements/front', name: 'app_evenement_front', methods: ['GET'])]
public function front(Request $request ,EvenementRepository $evenementRepository): Response
{
   // Create the search form
   $form = $this->createForm(EvenementSearchType::class);
   $form->handleRequest($request);

   // Get all events by default
   $evenements = $evenementRepository->findAll();

   // Filter events if the form is submitted and valid
   if ($form->isSubmitted() && $form->isValid()) {
       $criteria = $form->getData();
       $evenements = $evenementRepository->search($criteria);
   }

   return $this->render('evenement/front.html.twig', [
       'form' => $form->createView(), // Pass the form to the template
       'evenements' => $evenements,
   ]);
}
    #[Route('/evenements', name: 'app_evenement_index2', methods: ['GET', 'POST'])]
    public function index2(Request $request, EvenementRepository $evenementRepository): Response
    {
        // Create the search form
        $form = $this->createForm(EvenementSearchType::class);
        $form->handleRequest($request);

        // Default: show all events
        $evenements = $evenementRepository->findAll();

        // If the search form is submitted and valid, perform a search
        if ($form->isSubmitted() && $form->isValid()) {
            $criteria = $form->getData();
            $evenements = $evenementRepository->search($criteria); // Define this method in the repository
        }

        return $this->render('evenement/index.html.twig', [
            'form' => $form->createView(),
            'evenements' => $evenements,
        ]);
    }

    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(Evenement1Type::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{idEvenement}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/{idEvenement}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Evenement1Type::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{idEvenement}', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getIdEvenement(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
    }





    #[Route('/participate/{id}', name: 'app_evenement_participate', methods: ['GET'])]
    public function participate(int $id, UrlGeneratorInterface $urlGenerator, EvenementRepository $evenementRepository): Response
    {
        // Fetch the evenement entity using the provided ID
        $evenement = $evenementRepository->find($id);
    
        if (!$evenement) {
            throw $this->createNotFoundException('Événement introuvable.');
        }
    
        // Logic to handle participation (e.g., adding the user to the participants list)
    
        $this->addFlash('success', 'Vous avez participé à l\'événement avec succès !');
    
        // Redirect to the panier or participation list route
        return $this->redirectToRoute('app_participation_list');
    }


}
