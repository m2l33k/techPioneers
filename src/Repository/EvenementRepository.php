<?php

namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    /**
     * Méthode pour récupérer tous les événements (si nécessaire)
     */
    public function findAll(): array
    {
        return $this->createQueryBuilder('e')
            ->getQuery()
            ->getResult();
    }

    /**
     * Méthode de recherche avancée
     *
     * @param array $criteria
     * @return Evenement[]
     */
    public function search(array $criteria): array
    {
        $qb = $this->createQueryBuilder('e');

        // Critère : Titre de l'événement
        if (!empty($criteria['Titre_Evenement'])) {
            $qb->andWhere('e.Titre_Evenement LIKE :titre')
               ->setParameter('titre', '%' . $criteria['Titre_Evenement'] . '%');
        }

        // Critère : Date de l'événement
        if (!empty($criteria['Date_Evenement'])) {
            $qb->andWhere('e.Date_Evenement = :date')
               ->setParameter('date', $criteria['Date_Evenement']);
        }

        // Critère : Description de l'événement
        if (!empty($criteria['Description_Evenement'])) {
            $qb->andWhere('e.Description_Evenement LIKE :description')
               ->setParameter('description', '%' . $criteria['Description_Evenement'] . '%');
        }

        // Critère : Organisateur
        if (!empty($criteria['Organisateur_Evenement'])) {
            $qb->andWhere('e.Organisateur_Evenement LIKE :organisateur')
               ->setParameter('organisateur', '%' . $criteria['Organisateur_Evenement'] . '%');
        }

        // Critère : Lieu de l'événement
        if (!empty($criteria['Lieu_Evenement'])) {
            $qb->andWhere('e.Lieu_Evenement LIKE :lieu')
               ->setParameter('lieu', '%' . $criteria['Lieu_Evenement'] . '%');
        }

        // Critère : Catégorie
        if (!empty($criteria['category'])) {
            $qb->andWhere('e.category = :category')
               ->setParameter('category', $criteria['category']);
        }

        // Retourner les résultats
        return $qb->getQuery()->getResult();
    }
}
