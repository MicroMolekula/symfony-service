<?php

namespace App\Repository;

use App\Entity\Exercises;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use \App\Enum\EnumInventory;
use \App\Enum\EnumTarget;
/**
 * @extends ServiceEntityRepository<Exercises>
 */
class ExercisesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exercises::class);
    }

    //    /**
    //     * @return Exercises[] Returns an array of Exercises objects
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

    //    public function findOneBySomeField($value): ?Exercises
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findByTypesAndInventory(array $types, array $inventories): array
    {
        $typeValues = array_map(fn(EnumTarget $type) => $type->value, $types);
        $inventoryValues = array_map(fn(EnumInventory $inventory) => $inventory->value, $inventories);

        $qb = $this->createQueryBuilder('e');

        // Для каждого типа добавляем условие OR
        $typeOrX = $qb->expr()->orX();
        foreach ($typeValues as $type) {
            $typeOrX->add($qb->expr()->like('e.type', $qb->expr()->literal('%'.$type.'%')));
        }

        // Для каждого инвентаря добавляем условие OR
        $inventoryOrX = $qb->expr()->orX();
        foreach ($inventoryValues as $inventory) {
            $inventoryOrX->add($qb->expr()->like('e.inventory', $qb->expr()->literal('%'.$inventory.'%')));
        }

        return $qb
            ->where($typeOrX)
            ->andWhere($inventoryOrX)
            ->getQuery()
            ->getResult();
    }
}
