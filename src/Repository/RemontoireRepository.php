<?php

namespace App\Repository;

use App\Entity\Remontoire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Remontoire>
 *
 * @method Remontoire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Remontoire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Remontoire[]    findAll()
 * @method Remontoire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RemontoireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Remontoire::class);
    }

//    /**
//     * @return Remontoire[] Returns an array of Remontoire objects
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

//    public function findOneBySomeField($value): ?Remontoire
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
