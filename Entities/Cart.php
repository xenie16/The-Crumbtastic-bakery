<?php

declare(strict_types=1);

namespace Entities;

class Cart
{
   public int $cartId;
   public int $userId;
   public int $productId;
   public string $productName;
   public float $productPrice;
   public string $img;
   public int $quantity;

   public function __construct(int $cartId, int $user_id, int $product_id, string $product_name, float $product_price, string $img, int $quantity)
   {
      $this->cartId = $cartId;
      $this->userId = $user_id;
      $this->productId = $product_id;
      $this->productName = $product_name;
      $this->productPrice = $product_price;
      $this->img = $img;
      $this->quantity = $quantity;
   }

   public function getCartId(): int
   {
      return $this->cartId;
   }

   public function getUserId(): int
   {
      return $this->userId;
   }

   public function getProductId(): int
   {
      return $this->productId;
   }

   public function getProductName(): string
   {
      return $this->productName;
   }

   public function getProductPrice(): float
   {
      return $this->productPrice;
   }

   public function getFormattedPrice(): string
   {
      return number_format($this->productPrice, 2, '.', '');
   }

   public function getTotalPrice(): float
   {
      return $this->productPrice * $this->quantity;
   }

   public function getFormattedTotal(): string
   {
      return number_format($this->getTotalPrice(), 2, '.', '');
   }

   public function getImg(): string
   {
      return $this->img;
   }

   public function getQuantity(): int
   {
      return $this->quantity;
   }

   public function setQuantity(int $quantity): void
   {
      $this->quantity = $quantity;
   }

   public function setCartId(int $cartId): void
   {
      $this->cartId = $cartId;
   }

   public function setUserId(int $user_id): void
   {
      $this->userId = $user_id;
   }

   public function setProductId(int $product_id): void
   {
      $this->productId = $product_id;
   }

   public function setProductName(string $product_name): void
   {
      $this->productName = $product_name;
   }

   public function setProductPrice(float $product_price): void
   {
      $this->productPrice = $product_price;
   }

   public function setImg(string $img): void
   {
      $this->img = $img;
   }
}
