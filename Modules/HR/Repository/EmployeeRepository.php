<?php

namespace Modules\HR\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Modules\HR\Entity\Employee;

/**
 * @extends ServiceEntityRepository<Employee>
 *
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

//    /**
//     * @return Employee[] Returns an array of Employee objects
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

    public function FindOneByID($value): ?Employee
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function FindOneByIdentityID($value): ?Employee
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.identityid = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }
public function Count(array $criteria = []): int{
        return (int)$this->createQueryBuilder('e')
            ->select('count(e.id)')
            ->getQuery()
            ->getSingleScalarResult();
}
public function RemoveById($id): bool
{
    $entity = $this->find($id);
    if ($entity) {
        $entityManager = $this->getEntityManager();
        try {
            $entityManager->remove($entity);
            $entityManager->flush();
            return true;
        } catch (\Exception $e) {
            // Log exception if needed
            return false;
        }
    }
    return false;
}
public function GetEmployee($data): ?Employee{}
public function getEmployees($data): ?array {
    $queryBuilder = $this->createQueryBuilder('e');
    foreach ($data as $key => $value) {
        if ($value !== null && property_exists(Employee::class, $key)) {
            $queryBuilder->andWhere("e.$key = :$key")
                         ->setParameter($key, $value);
        } elseif ($value === null && property_exists(Employee::class, $key)) {
            $queryBuilder->andWhere("e.$key IS NULL"); //this supports if a key is null, for example when the fired property is null.
            //of course for that you could simply check if employed is true, but i decided to do it this way for god knows why.
        }
    }
    return $queryBuilder->getQuery()->getResult();
}
}
   
