<?php

declare(strict_types=1);

namespace Data;

use Exception;
use PDO;
use Config\DBConfig;

class UserDAO
{
   private PDO $pdo;

   public function __construct()
   {
      try {
         $this->pdo = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
         $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (Exception) {
         print "Something went wrong.";
         exit;
      }
   }

   public function getAllUsers(): array
   {
      try {
         $sql = "SELECT * FROM users";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute();
         return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (Exception) {
         print "Something went wrong";
         exit;
      }
   }

   public function createUserAndGetId(string $firstName, string $lastName, string $email, string $password, string $street, string $houseNumber, string $city, int $zipCode): int
   {
      try {
         $sql = "INSERT INTO users (first_name, last_name, email, `password`, `street`, house_number, city, zip_code) VALUES (:first_name, :last_name, :email, :password, :street, :house_number, :city, :zipCode)";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute([
            "first_name" => $firstName,
            "last_name" => $lastName,
            "email" => $email,
            "password" => $password,
            "street" => $street,
            "house_number" => $houseNumber,
            "city" => $city,
            "zipCode" => $zipCode
         ]);
         return (int)$this->pdo->lastInsertId();
      } catch (Exception) {
         print "Something went wrong";
         exit;
      }
   }

   public function checkIfEmailExists(string $email): string
   {
      try {
         $sql = "SELECT email FROM users WHERE email = :email";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute(["email" => $email]);
         $result = $stmt->fetch();

         if ($result === false) {
            return "";
         }

         return $result['email'];
      } catch (Exception) {
         print "Something went wrong";
         exit;
      }
   }

   public function getUserThroughLogin(string $email, string $password): ?array
   {
      try {
         $sql = "SELECT * FROM users WHERE email = :email AND `password` = :password";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute(["email" => $email, "password" => $password]);
         $result = $stmt->fetch(PDO::FETCH_ASSOC);

         if ($result === false) {
            return null;
         }

         return $result;
      } catch (Exception) {
         print "Something went wrong";
         exit;
      }
   }

   public function checkUserStatus(int $userId): ?string
   {
      try {
         $sql = "SELECT s.status
         FROM users u
         JOIN statuses s ON u.status_id = s.id
         WHERE u.id = :userId";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute(["userId" => $userId]);
         $result = $stmt->fetch(PDO::FETCH_ASSOC);
         return $result['status'];
      } catch (Exception) {
         print "Something went wrong";
         exit;
      }
   }

   public function updateUserStatus(int $userId, int $statusId): void
   {
      try {
         $sql = "UPDATE users SET status_id = :statusId WHERE id = :userId";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute(["statusId" => $statusId, "userId" => $userId]);
      } catch (Exception) {
         print "Something went wrong";
         exit;
      }
   }

   public function changePassword(int $userId, string $newPassword): void
   {
      try {
         $sql = "UPDATE users SET `password` = :newPassword WHERE id = :userId";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute(["newPassword" => $newPassword, "userId" => $userId]);
      } catch (Exception) {
         print "Something went wrong";
         exit;
      }
   }
}
