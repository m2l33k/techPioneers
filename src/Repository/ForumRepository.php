<?php

namespace App\Repository;

use App\Entity\Forum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Forum>
 */
class ForumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Forum::class);
    }

    public function searchForums(string $query)
    {
        // Create a QueryBuilder for custom queries
        $qb = $this->createQueryBuilder('f')
            ->leftJoin('f.createurForum', 'u') // Join with the User entity to filter by creator
            ->where('f.titreForum LIKE :query')  // Search by title
            ->orWhere('f.idForum = :query')     // Search by ID
            ->orWhere('u.nomUser LIKE :query')  // Search by creator's name
            ->setParameter('query', '%' . $query . '%');  // Use LIKE with wildcards

        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Forum[] Returns an array of Forum objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Forum
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
