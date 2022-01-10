<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\AccountFormType;
use App\Repository\AccountRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{

    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/{_locale}/accounts', name: 'account_index')]
    public function index(AccountRepository $accountRepository, ): Response
    {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
            'accounts' => $accountRepository->findAll(),
        ]);
    }

    #[Route('/{_locale}/accounts/new', name: 'account_form')]
    public function createAccount(Request $request): Response {
        $form = $this->createForm(AccountFormType::class, new Account());
        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid()){
            $this->em->persist($form->getData());
            $this->em->flush();
            return $this->redirectToRoute('account_index');
        }
        return $this->render('account/new.html.twig',[
           'form' => $form->createView()
        ]);
    }
}
