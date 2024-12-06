<?php

declare(strict_types=1);

spl_autoload_register();
session_start();

use Business\OrderService;
use Exceptions\noOrdersFoundException;

$tabTitle = "Orders";
$specificStyling = "orders";
$userId = $_SESSION['id'] ?? null;

// Sets the nav links
if (isset($userId) && $userId != 1) {
   header("Location: index.php");
   exit();
} elseif (isset($userId) && $userId == 1) {
   $navLinks = [
      "Shop" => "index.php",
      "About us" => "aboutUs.php",
      "My profile" => "profile.php",
      "Customers" => "customers.php",
      "Log out" => "index.php?action=logout"
   ];
} else {
   header("Location: index.php");
   exit();
}

// Get all orders
try {
   $orderService = new OrderService();
   $orders = $orderService->getAllOrders();

   // Group orders by date
   $groupedOrdersByDate = [];
   $groupedOrdersByDatePast = [];
   $today = new DateTime('today');

   foreach ($orders as $order) {
      $date = $order->getDate();
      $date = new DateTime($date);
      $formattedDate = $date->format('d-m-Y');

      if ($date >= $today) {
         if (!isset($groupedOrdersByDate[$formattedDate])) {
            $groupedOrdersByDate[$formattedDate] = [];
         }

         $orderId = $order->getId();

         if (!isset($groupedOrdersByDate[$formattedDate][$orderId])) {
            $groupedOrdersByDate[$formattedDate][$orderId] = [];
         }

         $groupedOrdersByDate[$formattedDate][$orderId][] = $order;
      } else {
         if (!isset($groupedOrdersByDatePast[$formattedDate])) {
            $groupedOrdersByDatePast[$formattedDate] = [];
         }

         $orderId = $order->getId();

         if (!isset($groupedOrdersByDatePast[$formattedDate][$orderId])) {
            $groupedOrdersByDatePast[$formattedDate][$orderId] = [];
         }

         $groupedOrdersByDatePast[$formattedDate][$orderId][] = $order;
      }
   }
} catch (noOrdersFoundException) {
   $message = "No orders found.";
} catch (Exception) {
   $message = "Something went wrong.";
   exit;
}

include('Presentation/header.php');
include('Presentation/orderList.php');
include('Presentation/footer.php');
