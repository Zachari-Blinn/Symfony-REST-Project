<?php
// api/src/Controller/GetCurrentUser.php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class GetCurrentUser
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

    return $user;
  }
}