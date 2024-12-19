<?php

namespace App\Controller;

use App\Entity\SubscriptionEvent;
use App\Repository\EvenementRepository;
use App\Repository\SubscriptionEventRepository;
use App\Repository\UserRepository;
use App\Entity\User;

use App\Service\MailjetService;
use Doctrine\Persistence\ManagerRegistry;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/subscription')]
class SubscriptionEventController extends AbstractController
{


    #[Route('/my-subscriptions', name: 'app_user_subscriptions')]
    public function mySubscriptions(
        Request $request,
        SubscriptionEventRepository $subscriptionEventRepository,
        EvenementRepository $evenementRepository,
        UserRepository $userRepository
    ) {
        // Récupérer l'utilisateur connecté
        /// $user = $this->getUser();
        $user = $this->getUser();
    

        // Paramètres de recherche, filtrage et tri
        $search = $request->query->get('search', '');
        $filter = $request->query->get('filter', '');
        $sort = $request->query->get('sort', 'date_desc');
        $page =  (int)$request->query->getInt('page', 1);
        $limit = 6;  // Nombre d'éléments par page

        // Utiliser le repository pour récupérer les abonnements
        $events = $subscriptionEventRepository->findUserSubscriptions(
            $user,
            $search,
            $filter,
            $sort,
            $page,
            $limit
        );

        // Récupérer le nombre total d'événements
        $totalEvents = $subscriptionEventRepository->countUserSubscriptions($user, $search, $filter);
        $totalPages = ceil($totalEvents / $limit);


        return $this->render('subscription_event/my_subscriptions.html.twig', [
            'events' => $events,
            'search' => $search,
            'filter' => $filter,
            'sort' => $sort,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }
    #[Route('/event', name: 'app_subscription_event.read')]
    public function index(

        EvenementRepository $evenementRepository,
        Request $request,
        UserRepository $userRepository

    ): Response
    {




        // Gestion des paramètres de requête
        $search = $request->query->get('search', '');
        $filter = $request->query->get('filter', '');
        $sort = $request->query->get('sort', '');
        $page = (int) $request->query->get('page', 1); // Valeur par défaut : 1
        $nbre = (int) $request->query->get('nbre', 6);

        // Appel des méthodes du repository avec l'utilisateur
        $events = $evenementRepository->findEvents1($search, $filter, $sort, $nbre, ($page - 1) * $nbre);
        $nbEvent = $evenementRepository->countFilteredEvents1($search, $filter);
        $nbrePage = ceil($nbEvent / $nbre);

        return $this->render('subscription_event/index.html.twig', [
            'events' => $events,
            'isPaginated' => true,
            'nbrePage' => $nbrePage,
            'page' => $page,
            'nbre' => $nbre,
            'search' => $search,
            'filter' => $filter,
            'sort' => $sort, // Passer le tri à la vue
        ]);

    }


   #[Route('/subscribe/{eventId}', name: 'app_subscription_event.subscribe')]
  public function subscription(
      int $eventId,
       EvenementRepository $evenementRepository,
       SubscriptionEventRepository $subscriptionEventRepository,
       UserRepository $userRepository ,
       ManagerRegistry $managerRegistry,
       MailjetService $mailjetService
   )
   {
       // Récupérer l'événement par ID
       $event = $evenementRepository->find($eventId);

       // Si l'événement n'existe pas
       if (!$event) {
           $this->addFlash('error', 'Événement introuvable.');
           return $this->redirectToRoute('app_subscription_event.read');
       }

       if($event->getCapacite() < 1 ){
           $this->addFlash('error', 'capacité de l evenement est saturé');
           return $this->redirectToRoute('app_subscription_event.read');
       }


       $user = $this->getUser();
       $existingSubscription = $subscriptionEventRepository->findOneBy(['user' => $user, 'event' => $event]);
       if ($existingSubscription) {
           $this->addFlash('error', 'Vous êtes déjà abonné à cet événement.');
           return $this->redirectToRoute('app_subscription_event.read');
       }
       // Créer l'objet SubscriptionEvent
       $subscriptionEvent = new SubscriptionEvent();
       $subscriptionEvent->setEvent($event);
       // avec session
       //$subscriptionEvent->setUser($this->getUser()); // Utilisateur connecté
       // sans session
       $subscriptionEvent->setUser($user);
       // Enregistrer la date d'abonnement
       $subscriptionEvent->setDate(new \DateTime());
       $em = $managerRegistry->getManager();
       $event->setCapacite($event->getCapacite() - 1);
       $em->persist($event);
       $em->persist($subscriptionEvent);
       $em->flush();
       $variables = [
           'title' => 'Bienvenue !',
           'content' => sprintf(
               "Bonjour %s, vous êtes maintenant inscrit à l'événement \"%s\" qui se déroulera le %s à %s.",
               $user->getUsername(),
               $event->getEventName(),
               $event->getEventDate()->format('d/m/Y'),
               $event->getEventPlace()
           )
       ];

    
       // Afficher un message flash de succès
       $this->addFlash('success', 'Vous êtes maintenant abonné à l\'événement !');
  return     $this->redirectToRoute('app_subscription_event.read');
       // Rediriger vers la page des événements
      // return $this->redirectToRoute('app_subscription_event.read');
   }
    #[Route('/unsubscribe/{id}', name: 'app_subscription_event.unsubscribe')]
    public function unsubscribe(
        $id,

        SubscriptionEventRepository $subscriptionEventRepository,

        ManagerRegistry $managerRegistry
    )
    {


        // Vérifier si l'utilisateur est déjà abonné à cet événement
        $existingSubscription = $subscriptionEventRepository->find($id);
        if (!$existingSubscription) {
            $this->addFlash('error', 'Vous n\'êtes pas abonné à cet événement.');
            return $this->redirectToRoute('app_user_subscriptions');
        }
       $event = $existingSubscription->getEvent();
        $event->setCapacite($event->getCapacite() + 1);
        // Supprimer l'abonnement
        $em = $managerRegistry->getManager();
        $em->persist($event);
        $em->remove($existingSubscription);
        $em->flush();

        // Afficher un message flash de succès
        $this->addFlash('success', 'Vous êtes désinscrit de l\'événement avec succès !');

        // Rediriger vers la page des abonnements de l'utilisateur
        return $this->redirectToRoute('app_user_subscriptions');
    }
    #[Route('/ticket/{eventId}', name: 'app_subscription_event.ticket')]
    public function ticket(
        int $eventId,
        EvenementRepository $evenementRepository,
        SubscriptionEventRepository $subscriptionEventRepository,
        UserRepository $userRepository,
        ManagerRegistry $managerRegistry
    )
    {
        // Récupérer l'événement par ID
        $event = $evenementRepository->find($eventId);

        // Si l'événement n'existe pas
        if (!$event) {
            $this->addFlash('error', 'Événement introuvable.');

        }
        // avec session
        // $existingSubscription = $subscriptionEventRepository->findOneBy(['user' => $this->getUser(), 'event' => $event]);
        // sans session statique
        $user = $this->getUser();

        // Créer l'objet SubscriptionEvent

        return     $this->generateAndDownloadPdf($event, $user);
        // Rediriger vers la page des événements
        // return $this->redirectToRoute('app_subscription_event.read');
    }

    #[Route('/download-pdf/{id}', name: 'app_download_event_pdf')]
    public function downloadEventPdf( $id, EvenementRepository $eventRepository): Response
    {
        // Récupérer l'événement
        $event = $eventRepository->find($id);

        if (!$event) {
            throw $this->createNotFoundException('L\'événement demandé n\'existe pas.');
        }

        // Initialiser DOMPDF avec des options
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        // Générer le HTML pour le PDF
        $html = $this->renderView('subscription_event/pdf_event_details.html.twig', [
            'event' => $event,
        ]);

        // Charger le HTML dans DOMPDF
        $dompdf->loadHtml($html);

        // (Optionnel) Définir la taille du papier et l'orientation
        $dompdf->setPaper('A4', 'portrait');

        // Rendre le PDF
        $dompdf->render();

        // Retourner le PDF comme réponse
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="event_' . $event->getEventName() . '_details.pdf"',
        ]);
    }

    private function generateAndDownloadPdf($event, $user): Response
    {
        // Contenu HTML avec design amélioré
        $html = '
    <style>
        body {
            font-family: "Arial", sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #f7f9fc;
        }
        .container {
            width: 100%;
            max-width: 700px;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            border: 2px solid #007BFF;
        }
        .header {
            background-color: #007BFF;
            padding: 30px;
            text-align: center;
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 2px;
        }
        .header p {
            font-size: 16px;
            margin: 5px 0 0;
        }
        .content {
            padding: 20px;
        }
        .content p {
            margin: 15px 0;
            font-size: 16px;
            line-height: 1.6;
        }
        .content strong {
            color: #007BFF;
        }
        .info-box {
            margin: 20px 0;
            padding: 15px;
            border: 1px dashed #007BFF;
            background-color: #f0f8ff;
            border-radius: 10px;
        }
        .footer {
            text-align: center;
            padding: 15px;
            background: #f0f8ff;
            color: #555;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }
        .footer p {
            margin: 0;
            font-size: 14px;
        }
    </style>
    <div class="container">
        <div class="header">
            <h1>Votre Billet</h1>
            <p>Événement : ' . htmlspecialchars($event->getEventName()) . '</p>
        </div>
        <div class="content">
            <p><strong>Participant :</strong> ' . htmlspecialchars($user->getUsername()) . '</p>
            <p><strong>Lieu :</strong> ' . htmlspecialchars($event->getEventPlace()) . '</p>
            <p><strong>Date :</strong> ' . $event->getEventDate()->format('Y-m-d') . '</p>
            <div class="info-box">
                <p><strong>Description :</strong></p>
                <p>' . htmlspecialchars($event->getEventDesc()) . '</p>
            </div>
        </div>
        <div class="footer">
            <p>Merci d\'avoir réservé. Veuillez présenter ce billet à l\'entrée.</p>
            <p>Powered by YourEvent</p>
        </div>
    </div>
    ';

        // Initialiser Dompdf
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Générer la réponse HTTP avec téléchargement
        return new Response(
            $dompdf->output(),
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="billet_evenement.pdf"',
            ]
        );
    }




}
