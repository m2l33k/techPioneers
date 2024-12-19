<?php

namespace App\Repository;

use App\Entity\Evenement;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evenement>
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

    //    /**
    //     * @return Evenement[] Returns an array of Evenement objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Evenement
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function search(string $search = '', string $categorie = '', string $sortByQuantite = 'ASC', int $page = 1, int $limit = 10)
    {
        $qb = $this->createQueryBuilder('e'); // 'e' est l'alias pour l'entité Evenement

        // Filtrage par nom ou description
        if ($search) {
            $qb->andWhere('e.eventName LIKE :search OR e.eventDesc LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        // Filtrage par catégorie (type d'événement)
        if ($categorie) {
            $qb->andWhere('e.typeEvenement = :categorie')
                ->setParameter('categorie', $categorie);
        }

        // Tri par capacité (si spécifié)
        if ($sortByQuantite) {
            $qb->orderBy('e.capacite', $sortByQuantite); // 'ASC' ou 'DESC'
        }

        // Pagination
        $qb->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }
    public function findEvents(string $search = '', string $filter = '', string $sort = '', int $limit = 8, int $offset = 0, Utilisateur $user): array
    {
        $qb = $this->createQueryBuilder('e')
            ->leftJoin('e.subscriptionEvents', 'se') // Jointure avec SubscriptionEvent
            ->andWhere('se.user IS NULL OR se.user != :user') // Exclure les événements auxquels l'utilisateur est abonné
            ->setParameter('user', $user);

        if (!empty($search)) {
            $qb->andWhere('e.EventName LIKE :search OR e.EventPlace LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        if (!empty($filter)) {
            $qb->andWhere('LOWER(TRIM(e.TypeEvenement)) = :filter')
                ->setParameter('filter', strtolower(trim($filter)));

        }

        // Appliquer le tri
        switch ($sort) {
            case 'name_asc':
                $qb->orderBy('e.EventName', 'ASC');
                break;
            case 'name_desc':
                $qb->orderBy('e.EventName', 'DESC');
                break;
            case 'date_asc':
                $qb->orderBy('e.EventDate', 'ASC');
                break;
            case 'date_desc':
                $qb->orderBy('e.EventDate', 'DESC');
                break;
            default:
                $qb->orderBy('e.EventDate', 'DESC'); // Tri par défaut
                break;
        }

        return $qb->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }

    public function countFilteredEvents(string $search = '', string $filter = '', Utilisateur $user): int
    {
        $qb = $this->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->leftJoin('e.subscriptionEvents', 'se') // Jointure avec SubscriptionEvent
            ->andWhere('se.user IS NULL OR se.user != :user') // Exclure les événements auxquels l'utilisateur est abonné
            ->setParameter('user', $user);

        if (!empty($search)) {
            $qb->andWhere('e.EventName LIKE :search OR e.EventPlace LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        if (!empty($filter)) {
            $qb->andWhere('LOWER(TRIM(e.TypeEvenement)) = :filter')
                ->setParameter('filter', strtolower(trim($filter)));

        }

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
    public function findEvents1(string $search = '', string $filter = '', string $sort = '', int $limit = 8, int $offset = 0): array
    {
        $qb = $this->createQueryBuilder('e');

        if (!empty($search)) {
            $qb->andWhere('e.EventName LIKE :search OR e.EventPlace LIKE :search')
                ->setParameter('search', '%' . $search . '%'); //   learn
        }

        if (!empty($filter)) {
            $qb->andWhere('LOWER(TRIM(e.TypeEvenement)) = :filter')
                ->setParameter('filter', strtolower(trim($filter)));

        }

        // Appliquer le tri
        switch ($sort) {
            case 'name_asc':
                $qb->orderBy('e.EventName', 'ASC');
                break;
            case 'name_desc':
                $qb->orderBy('e.EventName', 'DESC');
                break;
            case 'date_asc':
                $qb->orderBy('e.EventDate', 'ASC');
                break;
            case 'date_desc':
                $qb->orderBy('e.EventDate', 'DESC');
                break;
            default:
                $qb->orderBy('e.EventDate', 'DESC'); // Tri par défaut
                break;
        }

        return $qb->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }
    public function countFilteredEvents1(string $search = '', string $filter = ''): int
    {
        $qb = $this->createQueryBuilder('e')
            ->select('COUNT(e.id)');

        if (!empty($search)) {
            $qb->andWhere('e.EventName LIKE :search OR e.EventPlace LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        if (!empty($filter)) {
            $qb->andWhere('LOWER(TRIM(e.TypeEvenement)) = :filter')
                ->setParameter('filter', strtolower(trim($filter)));

        }

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
}
