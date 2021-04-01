<?php

namespace App\Repository;

use App\Entity\BlogMotsCles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BlogMotsCles|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogMotsCles|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogMotsCles[]    findAll()
 * @method BlogMotsCles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogMotsClesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogMotsCles::class);
    }

    // /**
    //  * @return BlogMotsCles[] Returns an array of BlogMotsCles objects
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
    public function findOneBySomeField($value): ?BlogMotsCles
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
