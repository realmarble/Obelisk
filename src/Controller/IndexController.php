<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request): Response|RedirectResponse
    {
        $session = $request->getSession();
        $id =$session->get('identity',null);
        if ($id != null){
        return $this->json(['message' => 'Logged in.','identity' => $id]);
        } else {
        return $this->json(['message' => 'Log in.']);
    }
    }
}
