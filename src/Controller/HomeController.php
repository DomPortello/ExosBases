<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    #[Route('/{_locale}', name: 'home')]
    public function index(GameRepository $gameRepository, CommentRepository $commentRepository, Request $request, string $_locale): Response
    {
        $_locale = $request->getLocale();
        $request->setLocale($_locale);


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'alphaGames' => $gameRepository->findAlphaGames(),
            'bestGames' => $gameRepository->findBestGames(),
            'lastGames' => $gameRepository->findLastGames(),
            'lastComments' => $commentRepository->findlastComments(),
        ]);
    }
}
