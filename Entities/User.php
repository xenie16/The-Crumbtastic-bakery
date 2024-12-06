<?php

declare(strict_types=1);

namespace Entities;

class User
{

   private int $id;
   private string $firstName;
   private string $lastName;
   private string $email;
   private string $password;
   private string $street;
   private string $houseNumber;
   private string $city;
   private int $zipCode;
   private int $statusId;

   public function __construct(int $id, string $firstName, string $lastName, string $email, string $password, string $street, string $houseNumber, string $city, int $zipCode, int $statusId)
   {
      $this->id = $id;
      $this->firstName = $firstName;
      $this->lastName = $lastName;
      $this->email = $email;
      $this->password = $password;
      $this->street = $street;
      $this->houseNumber = $houseNumber;
      $this->city = $city;
      $this->zipCode = $zipCode;
      $this->statusId = $statusId;
   }

   public function getId(): int
   {
      return $this->id;
   }

   public function getFirstName(): string
   {
      return $this->firstName;
   }

   public function getLastName(): string
   {
      return $this->lastName;
   }

   public function getEmail(): string
   {
      return $this->email;
   }

   public function getPassword(): string
   {
      return $this->password;
   }

   public function getStreet(): string
   {
      return $this->street;
   }

   public function getHouseNumber(): string
   {
      return $this->houseNumber;
   }

   public function getCity(): string
   {
      return $this->city;
   }

   public function getZipCode(): int
   {
      return $this->zipCode;
   }

   public function getStatusId(): int
   {
      return $this->statusId;
   }

   public function setFirstName(string $firstName): void
   {
      $this->firstName = $firstName;
   }

   public function setLastName(string $lastName): void
   {
      $this->lastName = $lastName;
   }

   public function setEmail(string $email): void
   {
      $this->email = $email;
   }

   public function setPassword(string $password): void
   {
      $this->password = $password;
   }

   public function setStreet(string $street): void
   {
      $this->street = $street;
   }

   public function setHouseNumber(string $houseNumber): void
   {
      $this->houseNumber = $houseNumber;
   }

   public function setCity(string $city): void
   {
      $this->city = $city;
   }

   public function setZipCode(int $zipCode): void
   {
      $this->zipCode = $zipCode;
   }

   public function setStatus(string $statusId): void
   {
      $this->statusId = $statusId;
   }
}
