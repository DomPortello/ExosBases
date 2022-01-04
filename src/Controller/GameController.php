<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/game')]

class GameController extends AbstractController
{
    private GameRepository $gameRepository;

    /**
     * @param GameRepository $gameRepository
     */
    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    /**
     * @return GameRepository
     */
    public function getGameRepository(): GameRepository
    {
        return $this->gameRepository;
    }

    /**
     * @param GameRepository $gameRepository
     */
    public function setGameRepository(GameRepository $gameRepository): void
    {
        $this->gameRepository = $gameRepository;
    }

    #[Route('/', name: 'game_index')]
    public function index(): Response
    {
        dump($this->gameRepository->findLastGames());
        return $this->render('game/index.html.twig', [
            'controller_name' => 'GameController',
            'games' => $this->gameRepository->findAlphaGames()
        ]);
    }

    #[Route('/{id}', name: 'game_show')]

    public function show(Game $game): Response
    {
        return $this->render('game/show.html.twig', [
            'game' => $game
        ]);
    }
}
