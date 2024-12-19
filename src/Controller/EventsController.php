<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use App\Service\UploadService;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/events')]
class EventsController extends AbstractController
{



    #[Route('/read/{page?1}/{nbre?8}', name: 'app_events.read')]
    public function read(EvenementRepository $evenementRepository, Request $request, $page , $nbre): Response
    {

        
        $search = $request->query->get('search', '');
        $filter = $request->query->get('filter', '');
        $sort = $request->query->get('sort', ''); // Récupérer le tri

        $events = $evenementRepository->findEvents1($search, $filter, $sort, $nbre, ($page - 1) * $nbre);
        $nbEvent = $evenementRepository->countFilteredEvents1($search, $filter);
        $nbrePage = ceil($nbEvent / $nbre);
        $this->denyAccessUnlessGranted('ROLE_STUDENT');
         return $this->render('events/index.html.twig', [
            'events' => $events,
            'isPaginated' => true,
            'nbrePage' => $nbrePage,
            'page' => $page,
            'nbre' => $nbre,
            'search' => $search,
            'filter' => $filter,
            'sort' => $sort, // Passer le tri à la vue
        ]);
        //   return  $this->json($events, Response::HTTP_OK);

    }





    #[Route('/detail/{id}', name: 'app_events.detail')]
    public function detail(
        EvenementRepository $evenementRepository,
        Request $request,
        $id
    ): Response
    {

    $event = $evenementRepository->find($id);
 $projet =  $event->getProjets();

        return $this->render('events/detail.html.twig',[
           'event' => $event,
            'projet' => $projet
        ]);
    }
    #[Route('/add', name: 'app_events.add')]
    public function add(
        Request $request,
        ManagerRegistry $managerRegistry,
        UploadService $uploadService
    ): Response
    {
        $event = new Evenement();
        $form = $this->createForm(EvenementType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if($image){
               $newFileName= $uploadService->uploadFile($image,$this->getParameter('event_directory'));
               $event->setImage($newFileName);
            }
            $event->setStatus(true);
            $em = $managerRegistry->getManager();
            $em->persist($event);
            $em->flush();
            $message = " a été ajouté avec succès";
            $this->addFlash('success',$message);
            $this->denyAccessUnlessGranted('ROLE_TEACHER');
            return $this->redirectToRoute('app_events.read');
        }
        $this->denyAccessUnlessGranted('ROLE_TEACHER');
        return $this->render('events/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/edit/{id}', name: 'app_events.edit')]
    public function edit(
        Evenement $event = null,
        Request $request,
        ManagerRegistry $managerRegistry,
        UploadService $uploadService
    ): Response
    {

        $form = $this->createForm(EvenementType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if($image){
                $newFileName= $uploadService->uploadFile($image,$this->getParameter('event_directory'));
                $event->setImage($newFileName);
            }

            $em = $managerRegistry->getManager();
            $em->persist($event);
            $em->flush();
            $message = " a été edité avec succès";
            $this->addFlash('success',$message);
            $this->denyAccessUnlessGranted('ROLE_TEACHER');
            return $this->redirectToRoute('app_events.read');
        }
        $this->denyAccessUnlessGranted('ROLE_TEACHER');
        return $this->render('events/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'app_events.delete')]
    public function delete(
        Evenement $event = null,
        ManagerRegistry $managerRegistry
    ): Response
    {
        $image = $this->getParameter('event_directory').'/'.$event->getImage();

        if($event){

            if (file_exists($image)) {

                $filesystem = new Filesystem();
                $filesystem->remove($this->getParameter('event_directory') . '/' . $image);
            }
            $em = $managerRegistry->getManager();
            $em->remove($event);
            $em->flush();
            $this->addFlash('success','evenement a été supprimer avec succé ');
        }else{
            $this->addFlash('error','evenement ne se trouve pas  ');
        }

        return $this->redirectToRoute('app_events.read');
    }
}
