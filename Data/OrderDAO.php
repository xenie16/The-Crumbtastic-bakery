<?php

declare(strict_types=1);

namespace Data;

use PDO;
use Exception;
use Config\DBConfig;

class OrderDAO
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

   public function getAllOrders(): array
   {
      try {
         $sql = "SELECT orders.id AS order_id, orders.user_id AS user_id, products.id AS product_id, products.name AS product_name, order_products.quantity, orders.date
         FROM orders
         INNER JOIN order_products ON orders.id = order_products.order_id
         INNER JOIN products ON order_products.product_id = products.id 
         ORDER BY orders.date, orders.id";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute();
         $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
         return $result;
      } catch (Exception) {
         print "Something went wrong";
         exit;
      }
   }

   public function getAllOrdersByUserId(int $userId): array
   {
      try {
         $sql = "SELECT orders.id AS order_id, orders.user_id, orders.date, products.id AS product_id, products.name AS product_name, products.img, order_products.quantity
         FROM orders
         INNER JOIN order_products ON orders.id = order_products.order_id
         INNER JOIN products ON order_products.product_id = products.id 
         WHERE orders.user_id = :user_id
         ORDER BY orders.date";

         $stmt = $this->pdo->prepare($sql);
         $stmt->execute(['user_id' => $userId]);
         $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
         return $result;
      } catch (Exception) {
         print "Something went wrong";
         exit;
      }
   }

   public function moveFromCartToOrder(int $userId, string $date): void
   {
      try {
         $this->pdo->beginTransaction();
         $sql = "INSERT INTO orders (user_id, date) VALUES (:user_id, :date)";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute([
            "user_id" => $userId,
            "date" => $date
         ]);

         $orderId = (int)$this->pdo->lastInsertId();

         $sql = "INSERT INTO order_products (order_id, product_id, quantity) 
         SELECT :order_id, cp.product_id, cp.quantity
         FROM cart_products cp
         JOIN carts c ON cp.cart_id = c.id
         WHERE c.user_id = :user_id";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute([
            "order_id" => $orderId,
            "user_id" => $userId
         ]);
         $this->pdo->commit();
      } catch (Exception) {
         $this->pdo->rollBack();
         print "Something went wrong";
         exit;
      }
   }


   public function checkIfDateExistsByUserId(string $date, int $userId): bool
   {
      try {
         $sql = "SELECT * FROM orders WHERE date = :date AND user_id = :user_id";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute([
            "date" => $date,
            "user_id" => $userId
         ]);
         return $stmt->rowCount() > 0;
      } catch (Exception) {
         print "Something went wrong";
         exit;
      }
   }

   public function getDateByOrderId(int $orderId): string
   {
      try {
         $sql = "SELECT `date` FROM orders WHERE id = :order_id";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute([
            "order_id" => $orderId
         ]);
         return $stmt->fetchColumn();
      } catch (Exception) {
         print "Something went wrong";
         exit;
      }
   }


   public function cancelOrder(int $orderId): void
   {
      try {
         $this->pdo->beginTransaction();

         $sql = "DELETE FROM order_products WHERE order_id = :order_id";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute([
            "order_id" => $orderId
         ]);

         $sql = "DELETE FROM orders WHERE id = :order_id";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute([
            "order_id" => $orderId
         ]);

         $this->pdo->commit();
      } catch (Exception) {
         $this->pdo->rollBack();
         print "Something went wrong";
         exit;
      }
   }
}
