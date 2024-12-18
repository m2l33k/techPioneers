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

    /**
     * Search forums based on a query (title or creator's name)
     */
    public function searchForumsByQuery(string $query = null)
{
    $qb = $this->createQueryBuilder('f');
    
    if ($query) {
        $qb->andWhere('f.titreForum LIKE :query OR f.descriptionForum LIKE :query')
           ->setParameter('query', '%' . $query . '%');
    }
    
    return $qb->getQuery()->getResult();
}

    

    /**
     * Filter forums based on creator, date, and activity
     */
    public function filterForums(?int $creatorId = null, ?string $sortByDate = null, ?bool $sortByActivity = null)
    {
        $qb = $this->createQueryBuilder('f')
            ->leftJoin('f.createurForum', 'u')
            ->addSelect('u');
        
        // Filter by creator if provided
        if ($creatorId) {
            $qb->andWhere('u.idUser = :creatorId')
                ->setParameter('creatorId', $creatorId);
        }
        
        // Sorting options
        if ($sortByDate) {
            if ($sortByDate === 'recent') {
                // Sort by most recent (newest forums first)
                $qb->orderBy('f.createdAt', 'DESC');
            } elseif ($sortByDate === 'earlier') {
                // Sort by earliest (oldest forums first)
                $qb->orderBy('f.createdAt', 'ASC');
            }
        }
        
        // Sorting by activity (if provided)
        if ($sortByActivity) {
            // Sort by activity (most active, based on number of messages)
            $qb->leftJoin('f.messages', 'm')
                ->addSelect('COUNT(m.IdMessageForum) AS HIDDEN numMessages')
                ->groupBy('f.idForum')
                ->orderBy('numMessages', 'DESC');
        }
        
        // Default order if no sorting option provided
        if (!$sortByDate && !$sortByActivity) {
            $qb->orderBy('f.createdAt', 'DESC');  // Default to most recent forums first
        }
        
        return $qb->getQuery()->getResult();
    }
    

}
