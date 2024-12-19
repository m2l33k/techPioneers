<?php

namespace App\Controller;

use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    private PanierService $panierService;

    public function __construct(PanierService $panierService)
    {
        $this->panierService = $panierService;
    }

    #[Route('/panier', name: 'app_panier_show', methods: ['GET'])]
    public function showPanier(): Response
    {
        $panierItems = $this->panierService->getPanier();

        return $this->render('panier/show.html.twig', [
            'panierItems' => $panierItems,
        ]);
    }

    #[Route('/panier/remove/{id}', name: 'app_panier_remove', methods: ['GET'])]
    public function removeFromPanier(int $id): Response
    {
        $this->panierService->removeFromPanier($id);

        $this->addFlash('success', 'L\'événement a été retiré du panier.');

        return $this->redirectToRoute('app_panier_show');
    }
}
