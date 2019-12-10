<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Voiture;
use App\Entity\VoitureSearch;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Query;

/**
 * @method Voiture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Voiture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Voiture[]    findAll()
 * @method Voiture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoitureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voiture::class);
    }

    public function findVoituresBySearch(VoitureSearch $search){

        $marque = $search->getMarque();
        $categorie = $search->getCategorie();
        $agence = $search->getAgence();
        $minTarif = $search->getMinTarif();
        $maxTarif = $search->getMaxTarif();

        $qb = $this->createQueryBuilder('v');

        if($marque){
            $qb->andWhere('v.marque = :mk')
               ->setParameter('mk', $marque);
        }
        if($agence){
            $qb->andWhere('v.agence = :ag')
               ->setParameter('ag', $agence);
        }
        if($categorie){
            $qb->innerJoin('v.categories', 'c', 'WITH', 'c = :cat')
               ->setParameter('cat', $categorie);
        }
        // if($categorie){
        //     $qb->andWhere('v.categories IN (:cat)')
        //        ->setParameter('cat', $categorie);
        // }
        if($maxTarif){
            $qb->andWhere('v.tarif <= :mxt')
                ->setParameter('mxt', $maxTarif);
        }
        if($minTarif){
            $qb->andWhere('v.tarif >= :mnt')
                ->setParameter('mnt', $minTarif);
        }
            
        $qb->orderBy('v.marque', 'ASC');

        return $qb->getQuery()->getResult();

    }


    
    // /**
    //  *@return Voiture[]
    //  */
    // public function findSearch(SearchData $search): array
    // {

    //     $query = $this
    //         ->createQueryBuilder('p')
    //         ->select('c', 'p')
    //         ->join('p.categories', 'c')
    //     ;
    //     if(!empty($search->q)){
    //         $query = $query
    //                     ->andWhere('p.marque LIKE :q')
    //                     ->setParameter('q', "%{$search->q}%")
    //     ;
    //     }
    //     if(!empty($search->min)){
    //         $query = $query
    //                     ->andWhere('p.tarif >= :min')
    //                     ->setParameter('min', $search->min)
    //     ;
    //     }
    //     if(!empty($search->max)){
    //         $query = $query
    //                     ->andWhere('p.tarif <= :max')
    //                     ->setParameter('max', $search->max)
    //     ;
    //     }
    //     if(!empty($search->categories)){
    //         $query = $query
    //                     ->andWhere('c.id IN (:categories)')
    //                     ->setParameter('categories', $search->categories)
    //     ;
    //     }

    //     return $query->getQuery()->getResult();

    // }



    /**
     * @return Voiture[]
     */
    public function voituresMarquesClassees(): array    //Méthode qui utilise le DQL
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT v
            FROM App\Entity\Voiture v
            JOIN v.marque m
            ORDER BY m.nom ASC'
        );
        // returns an array of Product objects
        return $query->getResult();
        
    }

    // /**
    //  * @return Query
    //  */
    // public function paginer(): Query
    // {
    //     return $this->findVisibleQuery();
    //                 ->getQuery();
    // }

    // private function findVisibleQuery(): QueryBuilder
    // {
    //     return $this->createQueryBuilder('p');
    //                 ->andWhere('p.sold=false');
    // }





    // /**
    //  * @return Voiture[] Returns an array of Voiture objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Voiture
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
