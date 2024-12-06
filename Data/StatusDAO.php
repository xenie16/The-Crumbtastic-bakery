<?php

declare(strict_types=1);

namespace Data;

use Exception;
use PDO;
use Config\DBConfig;

class StatusDAO
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

   public function getAllStatuses(): array
   {
      try {
         $sql = "SELECT * FROM statuses";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute();
         return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (Exception) {
         print "Something went wrong";
         exit;
      }
   }
}
