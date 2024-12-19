<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Projet;
use App\Form\EvenementType;
use App\Form\ProjetType;
use App\Repository\EvenementRepository;
use App\Repository\ProjetRepository;
use App\Service\UploadService;
use Doctrine\Persistence\ManagerRegistry;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/project')]
class ProjectController extends AbstractController
{


    #[Route('/detail/{id}', name: 'app_project.detail')]
    public function detail(
        ProjetRepository $projetRepository,
        Request $request,
        $id
    ): Response
    {

        $projet = $projetRepository->find($id);




        return $this->render('project/detail.html.twig',[
           'projet' => $projet
        ]);
    }

    #[Route('/read/{page?1}/{nbre?8}', name: 'app_project.read')]
    public function read(
        ProjetRepository $projetRepository,
        Request $request,
        int $page = 1,
        int $nbre = 8
    ): Response {
        $search = $request->query->get('search', '');
        $sort = $request->query->get('sort', '');
        $filter = $request->query->get('filter', '');

        $projets = $projetRepository->findProjets($search, $filter, $sort, $nbre, ($page - 1) * $nbre);
        $nbProjets = $projetRepository->countFilteredProjets($search, $filter);
        $nbrePage = ceil($nbProjets / $nbre);

        return $this->render('project/index.html.twig', [
            'projets' => $projets,
            'isPaginated' => true,
            'nbrePage' => $nbrePage,
            'page' => $page,
            'nbre' => $nbre,
            'search' => $search,
            'sort' => $sort,
            'filter' => $filter,
        ]);
    }

    #[Route('/add', name: 'app_project.add')]
    public function add(
        Request $request,
        ManagerRegistry $managerRegistry,
        UploadService $uploadService
    ): Response
    {
        $project = new Projet();
        $form = $this->createForm(ProjetType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $fichier = $form->get('fichier')->getData();
            if($fichier){
                $newFileName= $uploadService->uploadFile($fichier,$this->getParameter('projet_directory'));
                $project->setFichier($newFileName);
            }

            $em = $managerRegistry->getManager();
            $em->persist($project);
            $em->flush();
            $message = " a été ajouté avec succès";
            $this->addFlash('success',$message);
            return $this->redirectToRoute('app_project.read');
        }

        return $this->render('project/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'app_project.edit')]
    public function edit(
        Request $request,
        ManagerRegistry $managerRegistry,
        UploadService $uploadService,
        Projet $project = null
    ): Response
    {

        $form = $this->createForm(ProjetType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $fichier = $form->get('fichier')->getData();
            if($fichier){
                $newFileName= $uploadService->uploadFile($fichier,$this->getParameter('projet_directory'));
                $project->setFichier($newFileName);
            }

            $em = $managerRegistry->getManager();
            $em->persist($project);
            $em->flush();
            $message = " a été modifier avec succès";
            $this->addFlash('success',$message);
            return $this->redirectToRoute('app_project.read');
        }

        return $this->render('project/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/delete/{id}', name: 'app_project.delete')]
    public function delete(
        Projet $projet = null,
        ManagerRegistry $managerRegistry
    ): Response
    {
        $fichier = $this->getParameter('projet_directory').'/'.$projet->getFichier();

        if($projet){

            if (file_exists($fichier)) {

                $filesystem = new Filesystem();
                $filesystem->remove($this->getParameter('projet_directory') . '/' . $fichier);
            }
            $em = $managerRegistry->getManager();
            $em->remove($projet);
            $em->flush();
            $this->addFlash('success','projet a été supprimer avec succé ');
        }else{
            $this->addFlash('error','projet ne se trouve pas  ');
        }

        return $this->redirectToRoute('app_project.read');
    }
}
