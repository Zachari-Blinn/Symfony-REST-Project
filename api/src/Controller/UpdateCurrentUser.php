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

  public function __invoke(User $data): User
  {
    // get current user
    $currentUser = $this->_security->getUser();
    
    $userRepository = $this->_entityManager->getRepository(User::class);
    $user = $userRepository->findOneBy(['id' => $currentUser['id']]);

    $user->setFirstname($data['firstname']);

    $this->_entityManager->persist($user);
    $this->_entityManager->flush();

    return $user;
  }
}