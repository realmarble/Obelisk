<?php
namespace Modules\HR\Controllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HrController extends AbstractController
{
    public function index(): Response
    {
        return $this->json(['message' => 'Hello from HR module index action']);
    }

    public function profile(): Response
    {
        return $this->json(['message' => 'Hello from HR module profile action']);
    }
}
