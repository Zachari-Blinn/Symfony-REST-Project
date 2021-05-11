<?php
// api/src/Controller/GetCurrentCart.php

namespace App\Controller;

use App\Entity\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class GetCurrentCart
{
  /**
   * @param EntityManagerInterface
   */
  private $_entityManager;

  /**
   * @param Security
   */
  private $_security;

  public function __construct(EntityManagerInterface $entityManager, Security $security)
  {
    $this->_entityManager = $entityManager;
    $this->_security = $security;
  }

  public function __invoke()
  {
    // get current user
    $user = $this->_security->getUser();

    $cartRepository = $this->_entityManager->getRepository(Cart::class);
    $cart = $cartRepository->findOneBy(['user' => $user]);

    return $cart;
  }
}