<?php

namespace App\Repository;

use App\Entity\Properti;
use App\Entity\PropertiSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Properti>
 *
 * @method Properti|null find($id, $lockMode = null, $lockVersion = null)
 * @method Properti|null findOneBy(array $criteria, array $orderBy = null)
 * @method Properti[]    findAll()
 * @method Properti[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Properti::class);
    }

    public function save(Properti $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Properti $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Ici on renvoie la requête( via Query) et non le résultat de la requête, car nous voulons faire la pagination
     * @return Query
     */
    public function findAllVisibleQuery(PropertiSearch $search): Query{
        $query= $this->findVisibleQuery();

        //On peut faire un contrôle sur la prix max saisi
        if($search->getMaxPrice()){
            $query=$query
                 ->andWhere('p.price <= :maxprice')
                 ->setParameter('maxprice',$search->getMaxPrice());
        }
        //On peut faire un contrôle sur la surface min saisi
        if($search->getMinSurface()){
            $query=$query
                ->andWhere('p.surface >= :minsurface')
                ->setParameter('minsurface',$search->getMinSurface());
        }
          return $query->getQuery();
    }

    /**
     * @return Propertti[]
     */
    public function findLastest(): array {
        return $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return QueryBuilder
     */
    private function findVisibleQuery(): QueryBuilder {
        return $this->createQueryBuilder('p')
            ->where('p.sold = false');
    }

//    /**
//     * @return Properti[] Returns an array of Properti objects
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

//    public function findOneBySomeField($value): ?Properti
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
