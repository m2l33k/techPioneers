<?php

namespace App\Repository;

use App\Entity\Projet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Projet>
 */
class ProjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projet::class);
    }

    //    /**
    //     * @return Projet[] Returns an array of Projet objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Projet
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findProjets(
        string $search = '',
        string $filter = '',
        string $sort = '',
        int $limit = 8,
        int $offset = 0
    ): array {
        $qb = $this->createQueryBuilder('p');

        if (!empty($search)) {
            $qb->andWhere('p.title LIKE :search OR p.projetdesc LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        if (!empty($filter)) {
            $qb->andWhere('p.evenement = :filter')
                ->setParameter('filter', $filter);
        }

        switch ($sort) {
            case 'title_asc':
                $qb->orderBy('p.title', 'ASC');
                break;
            case 'title_desc':
                $qb->orderBy('p.title', 'DESC');
                break;
            case 'event_asc':
                $qb->orderBy('p.evenement', 'ASC');
                break;
            case 'event_desc':
                $qb->orderBy('p.evenement', 'DESC');
                break;
            default:
                $qb->orderBy('p.id', 'DESC');
                break;
        }

        return $qb->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }

    public function countFilteredProjets(string $search = '', string $filter = ''): int {
        $qb = $this->createQueryBuilder('p')
            ->select('COUNT(p.id)');

        if (!empty($search)) {
            $qb->andWhere('p.title LIKE :search OR p.projetdesc LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        if (!empty($filter)) {
            $qb->andWhere('p.evenement = :filter')
                ->setParameter('filter', $filter);
        }

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

}
