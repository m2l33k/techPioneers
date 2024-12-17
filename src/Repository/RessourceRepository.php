<?php

namespace App\Repository;

use App\Entity\Ressource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ressource>
 */
class RessourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ressource::class);
    }
    
   // Méthode pour chercher les ressources par leur titre
   public function findByTitreRessource(string $titreRessource)
   {
       return $this->createQueryBuilder('r')
           ->where('LOWER(r.Titre_Ressource) LIKE LOWER(:titreRessource)')
           ->setParameter('titreRessource', '%' . $titreRessource . '%')
           ->getQuery()
           ->getResult();
   }
    //    /**
    //     * @return Ressource[] Returns an array of Ressource objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Ressource
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
