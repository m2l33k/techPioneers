<?php
namespace App\Controller;

use App\Repository\EvenementRepository;
use App\Repository\ForumRepository;
use App\Repository\CoursRepository;
use App\Repository\RessourceRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/stat', name: 'app_stat_index')]
    public function index(
        EvenementRepository $evenementRepository,
        ForumRepository $forumRepository,
        CoursRepository $coursRepository,
        RessourceRepository $ressourceRepository,
        UserRepository $userRepository // Correctly named variable
    ): Response {
        // Fetch counts from repositories
        $totalEvents = $evenementRepository->count([]);
        $totalForums = $forumRepository->count([]);
        $totalCourses = $coursRepository->count([]);
        $totalResources = $ressourceRepository->count([]);
        $totalUsers = $userRepository->count([]); // Use correct variable name

        return $this->render('stat/index.html.twig', [
            'totalEvents' => $totalEvents,
            'totalForums' => $totalForums,
            'totalCourses' => $totalCourses,
            'totalResources' => $totalResources,
            'totalUsers' => $totalUsers,
        ]);
    }
}
