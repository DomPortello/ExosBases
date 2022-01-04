<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/comment', name: 'comment_index')]
class CommentController extends AbstractController
{
    #[Route('/', name: 'comment_index')]
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
            'comments' => $this->findlastComments()
        ]);
    }

    public function findlastComments(): array {
        return $this->createQueryBuilder('comment')
            ->select('comment')
            ->orderBy('comment.publishedAt', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }
}
