<?php
namespace Modules\HR\Controllers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Modules\HR\Entity\Employee;

class EmployeeController extends AbstractController
{
    public function auth(): Response
    {
        return $this->json(['identityid' => null]);
    }
    public function test(EntityManagerInterface $entityManager): Response
    {
        $employee = new Employee();
        $employee->setIdentityid('123');
        $employee->setFirstName('John');
        $employee->setLastName('Doe');
        $employee->setPosition('Software Developer');
        $employee->setSalary(60000);
        $employee->setHired(new \DateTime('2021-06-01'));
        $employee->setBirthDate(new \DateTime('1980-01-01'));
        $employee->setAddress('123 Main St');
        $employee->setEmployed(true);
        $entityManager->persist($employee);
        $entityManager->flush();
        // Other fields can be filled in a similar manner
        return $this->json(['status' => 'success']);
    }

    public function profile(): Response
    {
        return $this->json(['message' => 'Hello from HR module profile action']);
    }
}
