<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
class LoginController extends AbstractController
{
    #[Route('/auth', name: 'auth')]
    public function index(Request $request): Response|RedirectResponse
    {
        $session = $request->getSession();
        $secret = 'ckOZm03YNZUljhEZdAr1JcIGKwMnZL7g';  // Shared secret received on signup
        require_once('MonolithAPI.php');
        $mono = new Monolith();
        $decoded = $mono->decrypt($request->query->get('identity'), $secret);
        if ($decoded != null) {
        $session->set('identity', $decoded);
        return $this->json(['identityid' => $decoded]);
        } else {
            return $this->json(['error' => "something went wrong" ]);
        }
    }
}
