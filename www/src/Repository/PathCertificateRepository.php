<?php

namespace App\Repository;

use App\Entity\PathCertificate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PathCertificate|null find($id, $lockMode = null, $lockVersion = null)
 * @method PathCertificate|null findOneBy(array $criteria, array $orderBy = null)
 * @method PathCertificate[]    findAll()
 * @method PathCertificate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PathCertificateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PathCertificate::class);
    }

    // /**
    //  * @return PathCertificate[] Returns an array of PathCertificate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PathCertificate
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
