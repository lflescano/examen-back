<?php

namespace App\Repository;

use App\Entity\Alquiler;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Alquiler|null find($id, $lockMode = null, $lockVersion = null)
 * @method Alquiler|null findOneBy(array $criteria, array $orderBy = null)
 * @method Alquiler[]    findAll()
 * @method Alquiler[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlquilerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Alquiler::class);
    }

    // /**
    //  * @return Alquiler[] Returns an array of Alquiler objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Alquiler
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
