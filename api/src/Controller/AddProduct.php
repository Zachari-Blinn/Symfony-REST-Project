<?php
// api/src/Controller/AddProduct.php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class AddProduct
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

  /**
   * Add product with specified id to cart of current user 
   *
   * @param [type] $id
   * @return void
   */
  public function __invoke($id)
  {
    $productRepository = $this->_entityManager->getRepository(Product::class);
    $cartRepository = $this->_entityManager->getRepository(Cart::class);

    $user = $this->_security->getUser();

    $cart = $cartRepository->findOneBy(['user' => $user]);

    $product = $productRepository->findOneBy(['id' => $id]);

    $cart->addProduct($product);

    $this->_entityManager->persist($cart);
    $this->_entityManager->flush();

    return $cart;
  }
}