<?php
// api/src/Controller/RemoveAllOrder.php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class RemoveAllOrder
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
    //get current user
    $user = $this->_security->getUser();

    foreach ($user->getOrders() as $order) {
      $user->removeOrder($order);
    }

    $this->_entityManager->persist($user);
    $this->_entityManager->flush();

    return "Success";
  }
}