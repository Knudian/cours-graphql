<?php

namespace App\Repository;

use App\Entity\BookComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BookComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookComment[]    findAll()
 * @method BookComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookCommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BookComment::class);
    }

//    /**
//     * @return BookComment[] Returns an array of BookComment objects
//     */
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
    public function findOneBySomeField($value): ?BookComment
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
