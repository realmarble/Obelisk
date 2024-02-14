<?php
namespace Modules\HR\Controllers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Modules\HR\Entity\Employee;
use Modules\HR\Repository\EmployeeRepository;
use Symfony\Component\HttpFoundation\Request;

class EmployeeController extends AbstractController
{
    public function Create(EntityManagerInterface $entityManager,Request $request): Response
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
        // this would make sense but if we parse the json data into this we get 4 different errors
        
        return $this->json($data);
    }

    public function Count(EmployeeRepository $Repository): Response
    {
        $count = $Repository->Count();
        return $this->json(['message' => $count]);
    }
    public function GetEmployee(){
        return $this->json(['message' => "not implemented"]);
    }
}
