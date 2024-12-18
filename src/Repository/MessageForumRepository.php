<?php

namespace App\Repository;

use App\Entity\MessageForum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Forum;

/**
 * @extends ServiceEntityRepository<MessageForum>
 */
class MessageForumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessageForum::class);
    }
    public function searchByQuery($query): array
    {
        $qb = $this->createQueryBuilder('m')
            // Corrected association name: 'm.CreateurMessageForum' instead of 'm.createurMessageForum'
            ->leftJoin('m.CreateurMessageForum', 'u')
            ->leftJoin('m.forum', 'f');
        
        // If the query is numeric, search by ID (assuming 'm.IdMessageForum' is the correct field for the ID)
        if (is_numeric($query)) {
            $qb->where('m.IdMessageForum = :query');
        } else {
            // Else search by text fields
            $qb->where('m.ConetenuIdMessageForum LIKE :query')
               ->orWhere('u.username LIKE :query')  // Assuming 'u.username' is the correct field for user name
               ->orWhere('f.titreForum LIKE :query');  // Assuming 'f.titreForum' is the correct field for forum title
        }

        // Set the query parameter
        $qb->setParameter('query', is_numeric($query) ? (int)$query : '%' . $query . '%');
        
        return $qb->getQuery()->getResult();
    }

    public function searchByForumAndQuery(Forum $forum, ?string $search): array
{
    $qb = $this->createQueryBuilder('m')
        ->where('m.forum = :forum')
        ->setParameter('forum', $forum);

    if ($search) {
        $qb->andWhere('m.ConetenuIdMessageForum LIKE :search')
           ->setParameter('search', '%' . $search . '%');
    }

    return $qb->getQuery()->getResult();
}

    //    /**
    //     * @return MessageForum[] Returns an array of MessageForum objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?MessageForum
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
