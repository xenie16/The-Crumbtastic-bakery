<?php

declare(strict_types=1);

namespace Entities;

class Order
{
   private int $id;
   private int $userId;
   private int $productId;
   private string $productName;
   private string $date;
   private int $quantity;

   public function __construct(int $id, int $userId, int $productId, string $productName, string $date, int $quantity)
   {
      $this->id = $id;
      $this->userId = $userId;
      $this->productId = $productId;
      $this->productName = $productName;
      $this->date = $date;
      $this->quantity = $quantity;
   }

   public function getId(): int
   {
      return $this->id;
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

   public function getDate(): string
   {
      return $this->date;
   }

   public function getQuantity(): int
   {
      return $this->quantity;
   }

   public function setUserId(int $userId): void
   {
      $this->userId = $userId;
   }

   public function setProductId(int $productId): void
   {
      $this->productId = $productId;
   }

   public function setProductName(string $productName): void
   {
      $this->productName = $productName;
   }

   public function setDate(string $date): void
   {
      $this->date = $date;
   }

   public function setQuantity(int $quantity): void
   {
      $this->quantity = $quantity;
   }
}
