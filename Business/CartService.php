<?php

declare(strict_types=1);

namespace Business;

use Data\CartDAO;
use Entities\Cart;
use Entities\CartProduct;

class CartService
{
   private CartDAO $cartDAO;

   public function __construct()
   {
      $this->cartDAO = new CartDAO();
   }

   public function getAllCartProductsByUserId(int $userId): array
   {
      $records = $this->cartDAO->getAllCartProductsByUserId($userId);

      $cartProducts = [];

      foreach ($records as $record) {
         $cartProducts[] = new Cart(
            (int)$record['cart_id'],
            (int)$record['user_id'],
            (int)$record['product_id'],
            $record['product_name'],
            (float)$record['product_price'],
            $record['product_image'],
            (int)$record['quantity']
         );
      }

      return $cartProducts;
   }

   public function removeAllProductsFromCart(int $userId): void
   {
      $this->cartDAO->removeAllProductsFromCart($userId);
   }

   public function createCartAndGetId(int $userId): int
   {
      return $this->cartDAO->createCartAndGetId($userId);
   }

   private function getProductInCart(int $cartId, int $productId): ?CartProduct
   {
      $record = $this->cartDAO->getProductInCart($cartId, $productId);
      if (!empty($record)) {
         return new CartProduct((int)$record['cart_id'], (int)$record['product_id'], (int)$record['quantity']);
      } else {
         return null;
      }
   }

   public function insertIntoCart(int $userId, int $productId, int $quantity): void
   {
      $cartExistsCheck = $this->getAllCartProductsByUserId($userId);
      $cartId = null;

      if (empty($cartExistsCheck)) {
         $cartId = $this->createCartAndGetId($userId);
      } else {
         $cartId = $cartExistsCheck[0]->getCartId();
      }

      $productInCart = $this->getProductInCart($cartId, $productId);
      if (!empty($productInCart)) {
         $quantity += $productInCart->getQuantity();
         $this->updateCartQuantity($userId, $productId, $quantity);
      } else {
         $this->cartDAO->insertIntoCart($cartId, $productId, $quantity);
      }
   }

   public function updateCartQuantity(int $userId, int $productId, int $quantity): void
   {
      $this->cartDAO->updateCartQuantity($userId, $productId, $quantity);
   }

   public function removeProductFromCart(int $userId, int $productId): void
   {
      $this->cartDAO->removeProductFromCart($userId, $productId);
   }

   public function getCartTotalPriceByUserId(int $userId): string
   {
      return number_format($this->cartDAO->getCartTotalPriceByUserId($userId), 2, '.', '');
   }
}
