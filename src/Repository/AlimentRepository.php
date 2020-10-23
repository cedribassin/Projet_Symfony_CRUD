<?php

namespace App\Repository;

use App\Entity\Aliment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Aliment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aliment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aliment[]    findAll()
 * @method Aliment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlimentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aliment::class);
    }

    //Fonction générique qui permet de récupérer des info spécifiques
    //=> $propriete -> propriete sur laquelle on réalise le filtrage
    //=> $signe -> signe que l'on veut( <, = ou >)
    //=> $valeur -> la valeur que l'on souhaite
    public function getAlimentsParProprietes($propriete, $signe, $valeur){
        //on génère une requête qui va s'appeler a pour la table Aliment
        return $this->createQueryBuilder('a')
        //on rajoute les conditions: on retourne tous les aliments avec moins de 50 cal
        ->andWhere('a.'.$propriete.' '.$signe.' :val')
        ->setParameter('val', $valeur)
        ->getQuery()
        ->getResult()
        ;
    }

    // /**
    //  * @return Aliment[] Returns an array of Aliment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Aliment
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
