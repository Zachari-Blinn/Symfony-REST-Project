<?php
// api/src/Controller/UpdateCurrentUser.php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class UpdateCurrentUser
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

  public function __invoke(User $data)
  {
    //dump($data->getFirstname());die;
    $firstname = $data->getFirstname();
    // get current user
    $user = $this->_security->getUser();
    
    $user->setFirstname($firstname);

    $this->_entityManager->persist($user);
    $this->_entityManager->flush();

    return $user;
  }
}