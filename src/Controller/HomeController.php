<?php

namespace App\Controller;

use App\Repository\TournamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(TournamentRepository $tournamentRepository): Response
    {
        // Fetch highlighted or upcoming tournaments
        $upcomingTournaments = $tournamentRepository->findBy(['status' => 'UPCOMING'], ['startDate' => 'ASC'], 3);

        return $this->render('home/index.html.twig', [
            'upcoming_tournaments' => $upcomingTournaments,
        ]);
    }
}
