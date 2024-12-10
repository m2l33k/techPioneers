<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use App\Repository\RessourceRepository;
use App\Repository\CoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Dompdf\Dompdf;  // Ajoutez cette ligne
use Dompdf\Options;  // Et la ligne pour Options si ce n'est pas déjà fait


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
        // Récupérer les ressources associées à l'ID du cours
        $ressources = $ressourceRepository->findRessourcesByCoursId($Id_Cours);

        // Vérifiez si aucune ressource n'est trouvée
        if (empty($ressources)) {
            $this->addFlash('warning', 'Aucune ressource trouvée pour ce cours.');
        }

        // Rendre la vue
        return $this->render('cours/ressources.html.twig', [
            'ressources' => $ressources,
        ]);
    }

    #[Route('app_cours_index2', methods: ['GET'])]
    public function index2(Request $request,CoursRepository $coursRepository): Response
    {
       // Récupère le terme de recherche s'il existe
    $searchTerm = $request->query->get('search', '');

    // Si un terme de recherche est fourni, rechercher les cours correspondants, sinon tous les cours
    $cours = $searchTerm
        ? $coursRepository->findByTitle($searchTerm) // Méthode custom dans le repository pour rechercher
        : $coursRepository->findAll(); // Tous les cours si pas de recherche

    return $this->render('cours/index2.html.twig', [
        'cours' => $cours,
        'searchTerm' => $searchTerm, // Envoyer le terme de recherche pour le pré-remplir dans le champ
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

//meth bch pour afficher tous les ressources pour le front 
    #[Route('/ressources', name: 'app_all_ressources', methods: ['GET'])]
    public function allRessources(RessourceRepository $ressourceRepository): Response
    {
        $ressources = $ressourceRepository->findAll();
    
        return $this->render('cours/all_ressources.html.twig', [
            'ressources' => $ressources,
        ]);
    }
    #[Route('/{Id_Cours}/pdf', name: 'app_generate_pdf', methods: ['GET'])]
    public function generatePdf(Cours $cour): Response
    {
        // Récupérer le contenu que vous souhaitez mettre dans le PDF
        $html = $this->renderView('cours/pdf_template.html.twig', [
            'cour' => $cour
        ]);

        // Initialisation de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);
        
        // Charger le HTML dans Dompdf
        $dompdf->loadHtml($html);

        // (Optionnel) Définir la taille du papier (A4 par défaut)
        $dompdf->setPaper('A4', 'portrait');

        // Rendu du PDF
        $dompdf->render();

        // Générer le PDF en streaming
        return $dompdf->stream('cours_' . $cour->getIdCours() . '.pdf', [
            'Attachment' => 0, // 0 pour l'ouvrir dans le navigateur
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="cours_' . $cour->getIdCours() . '.pdf"',
        ]);
    }
}
    
   
   

