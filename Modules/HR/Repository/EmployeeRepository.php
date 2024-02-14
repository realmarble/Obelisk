<?php

namespace Modules\HR\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Modules\HR\Entity\Employee;
use Throwable;

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
public function RemoveById($id): bool //return true if success, and false for failure.
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
            //failure failure failure failure failure failure failure failure failure failure
        }
    }
    return false;
}
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
public function DisplayFirstXEmployees(int $amount, string $sortBy = 'id', string $sortOrder = 'ASC'): array|null //return array, even an empty one if correct, null if error
{
    // This method displays the first X employees from the database with optional sorting by column values.
    try {
        $employees = $this->findBy([], [$sortBy => $sortOrder], $amount);
        return $employees;
    } catch (Throwable $e) {
        return null;
    }
}
public function DisplayEmployeesRange(int $start, int $end, string $sortBy = 'id', string $sortOrder = 'ASC'): array|null
{
    // This method displays a range of employees from X to Y from the database with optional sorting by column values.
    try {
        $employees = $this->findBy([], [$sortBy => $sortOrder], $end, $start - 1);

        return $employees;
    } catch (Throwable $e) {
        return null;
    }
}
}

   
