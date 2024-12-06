<?php

declare(strict_types=1);

namespace Data;

use Exception;
use PDO;
use Config\DBConfig;

class CartDAO
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

   public function getAllCartProductsByUserId(int $userId): array
   {
      try {
         $sql = "SELECT c.id AS cart_id, c.user_id, cp.product_id, p.name AS product_name, p.price AS product_price, p.img AS product_image, cp.quantity
         FROM carts c
         JOIN cart_products cp ON c.id = cp.cart_id
         JOIN products p ON cp.product_id = p.id
         WHERE c.user_id = :user_id
         ORDER BY c.id, cp.product_id;";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute([
            "user_id" => $userId
         ]);
         $result = $stmt->fetchAll();
         return $result;
      } catch (Exception) {
         print "Something went wrong";
         exit;
      }
   }

   public function removeAllProductsFromCart(int $userId): void
   {
      try {
         $this->pdo->beginTransaction();

         $sql = "DELETE cp FROM cart_products cp JOIN carts c ON cp.cart_id = c.id WHERE c.user_id = :user_id";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute([
            "user_id" => $userId
         ]);

         $sql = "DELETE FROM carts WHERE user_id = :user_id";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute([
            "user_id" => $userId
         ]);

         $this->pdo->commit();
      } catch (Exception) {
         $this->pdo->rollBack();
         print "Something went wrong";
         exit;
      }
   }

   public function createCartAndGetId(int $userId): int
   {
      try {
         $sql = "INSERT INTO carts (user_id) VALUES (:user_id)";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute(["user_id" => $userId]);
         return (int)$this->pdo->lastInsertId();
      } catch (Exception) {
         print "Something went wrong";
         exit;
      }
   }

   public function insertIntoCart(int $cartId, int $productId, int $quantity): void
   {
      try {
         $sql = "INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute([
            "cart_id" => $cartId,
            "product_id" => $productId,
            "quantity" => $quantity
         ]);
      } catch (Exception) {
         print "Something went wrong";
         exit;
      }
   }

   public function updateCartQuantity(int $userId, int $productId, int $quantity): void
   {
      try {
         $sql = "
            UPDATE cart_products cp
            JOIN carts c ON cp.cart_id = c.id
            SET cp.quantity = :quantity
            WHERE c.user_id = :user_id AND cp.product_id = :product_id
        ";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute([
            "quantity" => $quantity,
            "user_id" => $userId,
            "product_id" => $productId
         ]);
      } catch (Exception) {
         print "Something went wrong";
         exit;
      }
   }

   public function getCartTotalPriceByUserId(int $userId): float
   {
      try {
         $sql = "SELECT SUM(cp.quantity * p.price) AS cart_total_sum 
         FROM carts c
         JOIN cart_products cp ON c.id = cp.cart_id
         JOIN products p ON cp.product_id = p.id
         WHERE c.user_id = :user_id;";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute([
            "user_id" => $userId
         ]);
         $result = $stmt->fetch();
         return (float)$result["cart_total_sum"];
      } catch (Exception) {
         print "Something went wrong";
         exit;
      }
   }

   public function getProductInCart(int $cartId, int $productId): array
   {
      try {
         $sql = "SELECT * FROM cart_products WHERE cart_id = :cart_id AND product_id = :product_id";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute([
            "cart_id" => $cartId,
            "product_id" => $productId
         ]);
         $result = $stmt->fetch(PDO::FETCH_ASSOC);

         if (empty($result)) {
            return [];
         }

         return $result;
      } catch (Exception) {
         print "Something went wrong";
         exit;
      }
   }

   public function removeProductFromCart(int $userId, int $productId): void
   {
      try {
         $sql = "DELETE FROM cart_products WHERE cart_id IN (SELECT id FROM carts WHERE user_id = :user_id) AND product_id = :product_id";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute([
            "user_id" => $userId,
            "product_id" => $productId
         ]);
      } catch (Exception) {
         print "Something went wrong";
         exit;
      }
   }
}
