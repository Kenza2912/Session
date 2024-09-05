<?php

namespace App\Repository;

use App\Entity\Trainee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trainee>
 */
class TraineeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trainee::class);
    }

       /**
        * @return Trainee[] Returns an array of Trainee objects
        */

        public function findByName(string $term): array
    {
        return $this->createQueryBuilder('t')
            ->where('t.name LIKE :name OR t.firstName LIKE :name')
            ->setParameter('name', '%' . $term . '%')
            ->orderBy('t.name', 'ASC')
            ->getQuery()
            ->getResult();
    }






    //    public function findOneBySomeField($value): ?Trainee
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}







