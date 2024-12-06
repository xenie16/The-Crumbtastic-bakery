<?php

declare(strict_types=1);

namespace Data;

use Exception;
use PDO;
use Config\DBConfig;

class ProductDAO
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

   public function getAllProducts(): array
   {
      try {
         $sql = "SELECT * FROM products";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute();
         $result = $stmt->fetchAll();
         return $result;
      } catch (Exception) {
         print "Something went wrong";
         exit;
      }
   }

   public function getProductById(int $id): array
   {
      try {
         $sql = "SELECT * FROM products WHERE id = :id";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute(['id' => $id]);
         $result = $stmt->fetch();
         return $result;
      } catch (Exception) {
         print "Something went wrong";
         exit;
      }
   }
}
