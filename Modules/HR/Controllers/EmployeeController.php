<?php
namespace Modules\HR\Controllers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Modules\HR\Entity\Employee;
use Modules\HR\Repository\EmployeeRepository;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class EmployeeController extends AbstractController
{
public function Create(EntityManagerInterface $entityManager, Request $request): Response
{
    try {
        $content = $request->getContent();
        $data = json_decode($content);

        $employee = new Employee();

        // Define a mapping of JSON properties to setter methods
        $mapping = [
            'identityid' => 'setIdentityid',
            'firstName' => 'setFirstName',
            'lastName' => 'setLastName',
            'position' => 'setPosition',
            'salary' => 'setSalary',
            'hired' => 'setHired',
            'birthDate' => 'setBirthDate',
            'address' => 'setAddress',
            'employed' => 'setEmployed',
            'fired' => 'setFired',
        ];

        foreach ($mapping as $jsonProp => $setterMethod) {
            if (isset($data->$jsonProp)) {
                $value = $data->$jsonProp;

                // Special handling for DateTime properties
                if (in_array($jsonProp, ['hired', 'birthDate', 'fired']) && $value !== null) {
                    $value = new \DateTime($value);
                }

                // Call the setter method if it exists
                if (method_exists($employee, $setterMethod)) {
                    $employee->$setterMethod($value);
                }
            }
        }

        $entityManager->persist($employee);
        $entityManager->flush();

        // Assuming a method to serialize your employee exists
        return $this->json([
            'message' => 'Employee created successfully',
            // You can serialize your employee here if needed
        ]);
    } catch (Throwable $e) {
        // Log the error message for debugging purposes
        // error_log($e->getMessage());

        return $this->json([
            'error' => $e,
        ]);
    }
}


    public function Count(EmployeeRepository $Repository): Response
    {
        //return the amount of employees in the database. used for correctly formatting the display.
        //if it ever actually materializes.
        $count = $Repository->Count();
        return $this->json(['data' => $count]);
    }
    public function GetEmployees(Request $request,EmployeeRepository $Repository): Response{
        //returns list of employees based on the filters/values specified in the JSON POST request supplied to it.
        $content = $request->getContent();
        $data = json_decode($content); //get the data of the POST request
        $result = $Repository->GetEmployees($data); //this method works only on the basis of shit-fuck. i Suggest for whoever wrote it to either not use it, or completely rewrite it.
        return $this->json(['data' => $result]);
    }
    public function DisplayFirstXEmployees(Request $request, EmployeeRepository $Repository, int $amount, string $sortBy = 'id', string $sortOrder = 'ASC'): Response
    {
        // This method displays the first X employees from the database with optional sorting by column values.
        try {
            $employees = $Repository->findBy([], [$sortBy => $sortOrder], $amount);

            return $this->json([
                'data' => $employees
            ]);
        } catch (Throwable $e) {
            return $this->json([
                'error' => $e->getMessage(),
            ]);
        }
    }
    public function DisplayEmployeesRange(Request $request, EmployeeRepository $Repository, int $start, int $end, string $sortBy = 'id', string $sortOrder = 'ASC'): Response
    {
        // This method displays a range of employees from X to Y from the database with optional sorting by column values.
        try {
            $employees = $Repository->findBy([], [$sortBy => $sortOrder], $end, $start - 1);

            return $this->json([
                'data' => $employees
            ]);
        } catch (Throwable $e) {
            return $this->json([
                'error' => $e->getMessage(),
            ]);
        }
    }
}
