<?php
namespace Modules\HR\Controllers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Modules\HR\Entity\Employee;
use Symfony\Component\HttpFoundation\Request;

class EmployeeController extends AbstractController
{
    public function auth(): Response
    {
        return $this->json(['identityid' => null]);
    }
    public function test(EntityManagerInterface $entityManager,Request $request): Response
    {
        $content = $request->getContent();
        $data = json_decode($content);
         $employee = new Employee();
         $employee->setIdentityid("placeholdder");
         $employee->setFirstName("placeholdder");
         $employee->setLastName("placeholdder");
         $employee->setPosition("placeholdder");
         $employee->setSalary(6000);
         $employee->setHired(new \DateTime("1970-01-01"));
         $employee->setBirthDate(new \DateTime("1970-01-01"));
         $employee->setAddress("placeholder");
         $employee->setEmployed(true);
         $employee->setFired(new \DateTime("1970-01-01"));
         $entityManager->persist($employee);
         $entityManager->flush();
        // Other fields can be filled in a similar manner
        
        return $this->json($data);
    }

    public function profile(): Response
    {
        return $this->json(['message' => 'Hello from HR module profile action']);
    }
}
