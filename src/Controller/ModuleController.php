<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ModuleController extends AbstractController
{
    #[Route('/module/{moduleName}', name: 'app_module')]
    public function index(string $moduleName): Response
    {
        $response = new Response(
            $moduleName,
            200,
            ['content-type' => 'text/plain']
        );
        return $response;
    }
}
