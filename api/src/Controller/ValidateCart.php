<?php
// api/src/Controller/ValidateCart.php

namespace App\Controller;

use Error;
use App\Entity\Cart;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class ValidateCart
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
   * converting the cart to an order
   *
   * @return void
   */
  public function __invoke()
  {
    $cartRepository = $this->_entityManager->getRepository(Cart::class);

    $user = $this->_security->getUser();

    $order = new Order();
    $order->setAuthor($user);

    $cart = $cartRepository->findOneBy(['user' => $user]);

    if(!$cart->getProduct()->isEmpty()) {
      $totalPrice = 0;

      foreach ($cart->getProduct() as $product) {
        $totalPrice = $totalPrice + $product->getPrice();
        $order->addProduct($product);
        $cart->removeProduct($product);
      }
  
      $order->setTotalPrice($totalPrice);
  
      $this->_entityManager->persist($cart);
      $this->_entityManager->persist($order);
      $this->_entityManager->flush();
    } else {
      throw new Error("Cart cannot be empty!");
    }
  }
}