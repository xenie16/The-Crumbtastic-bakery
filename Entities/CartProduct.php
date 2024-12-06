<?php

declare(strict_types=1);

namespace Entities;

class CartProduct
{
   public int $cart_id;
   public int $product_id;
   public int $quantity;

   public function __construct(int $cart_id, int $product_id, int $quantity)
   {
      $this->cart_id = $cart_id;
      $this->product_id = $product_id;
      $this->quantity = $quantity;
   }

   public function getCartId(): int
   {
      return $this->cart_id;
   }

   public function getProductId(): int
   {
      return $this->product_id;
   }

   public function getQuantity(): int
   {
      return $this->quantity;
   }

   public function setQuantity(int $quantity): void
   {
      $this->quantity = $quantity;
   }
}
