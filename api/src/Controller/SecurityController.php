<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{  
  #[Route(path: '/api/login', name: 'api_login', methods: ['POST'])]
  public function login() {
    $user = $this->getUser();
    return $this->json([
      'username' => $user->getUsername(),
      'roles' => $user->getRoles()
    ]);
  }
}