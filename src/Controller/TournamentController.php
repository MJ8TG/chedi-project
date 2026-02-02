<?php

namespace App\Controller;

use App\Entity\Tournament;
use App\Repository\GameRepository;
use App\Repository\TournamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TournamentController extends AbstractController
{
    #[Route('/tournaments', name: 'app_tournaments_index', methods: ['GET'])]
    public function index(Request $request, TournamentRepository $tournamentRepository, GameRepository $gameRepository): Response
    {
        $status = $request->query->get('status');
        $gameId = $request->query->get('game');

        $tournaments = $tournamentRepository->findByFilters($status, $gameId);
        $games = $gameRepository->findAll();

        return $this->render('tournament/index.html.twig', [
            'tournaments' => $tournaments,
            'games' => $games,
            'current_status' => $status,
            'current_game' => $gameId,
        ]);
    }

    #[Route('/tournaments/{id}', name: 'app_tournaments_show', methods: ['GET'])]
    public function show(Tournament $tournament): Response
    {
        return $this->render('tournament/show.html.twig', [
            'tournament' => $tournament,
        ]);
    }
}
