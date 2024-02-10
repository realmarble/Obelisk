<?php
namespace Modules\HR\Controllers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    public function auth(): Response
    {
        return $this->json(['identityid' => null]);
    }

    public function profile(): Response
    {
        return $this->json(['message' => 'Hello from HR module profile action']);
    }
}
