<?php

namespace App\Repository;

use App\Entity\BlogArticles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BlogArticles|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogArticles|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogArticles[]    findAll()
 * @method BlogArticles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogArticlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogArticles::class);
    }

    // /**
    //  * @return BlogArticles[] Returns an array of BlogArticles objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BlogArticles
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
