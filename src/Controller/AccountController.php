<?php

namespace App\Controller;

use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/{_locale}/accounts', name: 'account_index')]
    public function index(AccountRepository $accountRepository): Response
    {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
            'accounts' => $accountRepository->findAll(),
        ]);
    }
}
