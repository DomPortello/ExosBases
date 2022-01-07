<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/{_locale}/game')]

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
    public function index(Request $request): Response
    {
        return $this->render('game/index.html.twig', [
            'controller_name' => 'GameController',
            'games' => $this->gameRepository->findAlphaGames(50, true)
        ]);
    }

    #[Route('/detail/{slug}', name: 'game_show')]
    public function show(Game $game, Request $request, string $slug): Response
    {
        dump($this->gameRepository->findBySlug($slug));
        return $this->render('game/show.html.twig', [
            'game' => $this->gameRepository->findBySlug($slug)
        ]);
    }
}
