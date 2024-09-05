<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

//    /**
//     * @return Session[] Returns an array of Session objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    *********requette sql *********
// SELECT t.name, t.first_name
// FROM trainee t
// WHERE t.id NOT IN (SELECT tt.trainee_id FROM session_trainee tt WHERE tt.trainee_id = trainee_id);

        public function findTraineeNotInSession($sessionId): array
        {

            $em = $this->getEntityManager();

            // Sous-requête pour sélectionner les stagiaires déjà inscrits à la session
            $subQuery = $em->createQueryBuilder()
                ->select('trainee.id')
                ->from('App\Entity\Trainee', 'trainee')
                ->leftJoin('trainee.sessions', 'session')
                ->where('session.id = :sessionId')
                ->getDQL();
        
            // Requête principale pour sélectionner les stagiaires non inscrits
            $queryBuilder = $em->createQueryBuilder();
            $queryBuilder->select('t')
                ->from('App\Entity\Trainee', 't')
                ->where($queryBuilder->expr()->notIn('t.id', $subQuery))
                ->setParameter('sessionId', $sessionId)
                ->orderBy('t.name', 'ASC');
        
            // Renvoyer le résultat
            return $queryBuilder->getQuery()->getResult();
        }

//    public function findOneBySomeField($value): ?Session
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
