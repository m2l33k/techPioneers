<?php

namespace App\Repository;

use App\Entity\Evenement;
use App\Entity\SubscriptionEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SubscriptionEvent>
 */
class SubscriptionEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubscriptionEvent::class);
    }

    //    /**
    //     * @return SubscriptionEvent[] Returns an array of SubscriptionEvent objects
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

    //    public function findOneBySomeField($value): ?SubscriptionEvent
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findUserSubscriptions(
        $user,
        $search = '',
        $filter = '',
        $sort = 'date_desc',
        $page = 1,
        $limit = 10
    ) {
        $qb = $this->createQueryBuilder('se')
            ->join('se.event', 'e')  // Joindre la table Evenement
            ->where('se.user = :user')
            ->setParameter('user', $user);

        // Recherche par nom de l'événement ou lieu
        if ($search) {
            $qb->andWhere('e.EventName LIKE :search OR e.EventPlace LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        // Filtrage par type d'événement
        if ($filter) {
            $qb->andWhere('e.TypeEvenement = :filter')
                ->setParameter('filter', $filter);
        }

        // Tri des événements
        switch ($sort) {
            case 'name_asc':
                $qb->orderBy('e.EventName', 'ASC');
                break;
            case 'name_desc':
                $qb->orderBy('e.EventName', 'DESC');
                break;
            case 'date_asc':
                $qb->orderBy('e.EventDate', 'ASC'); // Utilisez le nom correct du champ ici
                break;
            case 'date_desc':
            default:
                $qb->orderBy('e.EventDate', 'DESC'); // Utilisez le nom correct du champ ici
                break;
        }

        // Pagination
        $qb->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }
    public function countUserSubscriptions($user, $search = '', $filter = '')
    {
        $qb = $this->createQueryBuilder('se')
            ->join('se.event', 'e')
            ->where('se.user = :user')
            ->setParameter('user', $user);

        // Recherche par nom de l'événement ou lieu
        if ($search) {
            $qb->andWhere('e.EventName LIKE :search OR e.EventPlace LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        // Filtrage par type d'événement
        if ($filter) {
            $qb->andWhere('e.TypeEvenement = :filter')
                ->setParameter('filter', $filter);
        }

        return (int) $qb->select('COUNT(se.id)')->getQuery()->getSingleScalarResult();
    }
    public function findEventBySubscriptionId(int $subscriptionId): ?Evenement
    {
        $qb = $this->createQueryBuilder('subscription')
            ->select('event')
            ->join('subscription.event', 'event') // Jointure avec l'entité `Evenement`
            ->where('subscription.id = :id')
            ->setParameter('id', $subscriptionId);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
