<?php

declare(strict_types=1);

namespace Entities;

class Product
{

   private int $id;
   private string $name;
   private float $price;
   private string $img;
   private string $description;

   public function __construct(int $id, string $name, float $price, string $img, string $description)
   {
      $this->id = $id;
      $this->name = $name;
      $this->price = $price;
      $this->img = $img;
      $this->description = $description;
   }

   public function getId(): int
   {
      return $this->id;
   }

   public function getName(): string
   {
      return $this->name;
   }

   public function getPrice(): float
   {
      return round($this->price, 2);
   }

   public function getFormattedPrice(): string
   {
      return number_format($this->price, 2, '.', '');
   }

   public function getImg(): string
   {
      return $this->img;
   }

   public function getDescription(): string
   {
      return $this->description;
   }

   public function setName(string $name): void
   {
      $this->name = $name;
   }

   public function setPrice(float $price): void
   {
      $this->price = $price;
   }

   public function setImg(string $img): void
   {
      $this->img = $img;
   }

   public function setDescription(string $description): void
   {
      $this->description = $description;
   }
}
