<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\Library;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\This;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    /**
     * @param int $limit
     * @param bool $isOrderedByName
     * @return array
     */

    public function findAlphaGames(int $limit = 10, bool $isOrderedByName = false):array {
        $qb = $this->createQueryBuilder('game')
            ->select('game');

        if ($isOrderedByName){
            $qb->orderBy('game.name', 'ASC');
        }else{
            $qb->orderBy('game.name', 'DESC');
        }

        return $qb->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }


    public function findLastGames(): array {
        return $this->createQueryBuilder('game')
            ->select('game')
            ->orderBy('game.publishedAt', 'ASC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $limit
     * @return array
     */

    public function findBestGames(int $limit = 10): array {
        return $this->createQueryBuilder('game')
            ->select('game')
            ->join(Library::class, 'libraries', 'WITH', 'libraries.game = game')
            ->groupBy('game')
            ->orderBy('count(game)', 'DESC')
            ->getQuery()
            ->setMaxResults($limit)
            ->getResult();
    }

    public function findAllNames(string $name): array
    {
        return $this->createQueryBuilder('game')
            ->select('game.name', 'game.id')
            ->where('game.name LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findBySlug(string $slug): Game
    {
        return $this->createQueryBuilder('game')
            ->select('game', 'languages', 'genres', 'comments', 'account')
            ->join('game.genres', 'genres')
            ->join('game.languages', 'languages')
            ->join('game.comments', 'comments')
            ->join('comments.account', 'account')
            ->where('game.slug = :slug')
            ->setParameter('slug', $slug)
            ->orderBy('comments.createdAt', 'DESC')
            ->getQuery()
            ->getOneOrNullResult();
    }


    // /**
    //  * @return Game[] Returns an array of Game objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Game
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
