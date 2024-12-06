<?php

declare(strict_types=1);

namespace Business;

use Data\OrderDAO;
use Exceptions\dateAlreadyExistsException;
use Exceptions\orderNotCancellableException;
use Exceptions\noOrdersFoundException;
use Entities\Order;

class OrderService
{
   private OrderDAO $orderDAO;

   public function __construct()
   {
      $this->orderDAO = new OrderDAO();
   }

   public function getAllOrders(): array
   {
      $records = $this->orderDAO->getAllOrders();

      if (empty($records)) {
         throw new noOrdersFoundException();
      }

      $orders = [];

      foreach ($records as $record) {
         $orders[] = new Order((int)$record['order_id'], (int)$record['user_id'], (int)$record['product_id'], $record['product_name'], $record['date'], (int)$record['quantity']);
      }

      return $orders;
   }

   public function getAllOrdersByUserId(int $userId): array
   {
      $records = $this->orderDAO->getAllOrdersByUserId($userId);

      if (empty($records)) {
         throw new noOrdersFoundException();
      }

      $orders = [];

      foreach ($records as $record) {
         $orders[] = new Order((int)$record['order_id'], (int)$record['user_id'], (int)$record['product_id'], $record['product_name'], $record['date'], (int)$record['quantity']);
      }
      return $orders;
   }

   public function moveFromCartToOrder(int $userId, string $date): void
   {
      if ($this->checkIfDateExists($date, $userId)) {
         throw new dateAlreadyExistsException();
      }

      $this->orderDAO->moveFromCartToOrder($userId, $date);
   }

   public function cancelOrder(int $orderId): void
   {
      $orderDate = $this->getDateByOrderId($orderId);
      $currentDate = date("Y-m-d");

      if ($orderDate === $currentDate) {
         throw new orderNotCancellableException();
      }
      $this->orderDAO->cancelOrder($orderId);
   }

   private function checkIfDateExists(string $date, int $userId): bool
   {
      return $this->orderDAO->checkIfDateExistsByUserId($date, $userId);
   }

   private function getDateByOrderId(int $orderId): string
   {
      return $this->orderDAO->getDateByOrderId($orderId);
   }
}
