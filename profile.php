<?php

declare(strict_types=1);

spl_autoload_register();
session_start();

use Business\OrderService;
use Exceptions\orderNotCancellableException;
use Exceptions\noOrdersFoundException;


$tabTitle = "My profile";
$navLinks = [];
$userId = $_SESSION['id'] ?? null;
$specificStyling = "profile";
$currentDate = date("d-m-Y");
$error = "";

$orderService = new OrderService();

// Sets the nav links
if (isset($userId) && $userId != 1) {
   $navLinks = [
      "Shop" => "index.php",
      "About us" => "aboutUs.php",
      "Log out" => "index.php?action=logout"
   ];
} elseif (isset($userId) && $userId == 1) {
   $navLinks = [
      "Shop" => "index.php",
      "About us" => "aboutUs.php",
      "My profile" => "profile.php",
      "Orders" => "orders.php",
      "Customers" => "customers.php",
      "Log out" => "index.php?action=logout",
   ];
} else {
   $navLinks = [
      "Shop" => "index.php",
      "About us" => "aboutUs.php",
      "Log in" => "login.php",
      "Sign up" => "register.php"
   ];
}

// Cancel order
if (isset($_POST['cancelOrder']) && isset($_POST['orderId'])) {
   $orderId = (int)$_POST['orderId'];
   try {
      $orderService->cancelOrder($orderId);
      header("Location: profile.php");
      exit();
   } catch (orderNotCancellableException) {
      $error = "Today's order cannot be cancelled.";
   } catch (Exception $e) {
      echo "Something went wrong: " . $e->getMessage();
      exit;
   }
}

include('Presentation/header.php');

// Get all orders
try {
   $orders = $orderService->getAllOrdersByUserId($userId);

   // Group orders by date
   $groupedOrdersByDate = [];
   $groupedOrdersByDatePast = [];
   $today = new DateTime('today');

   foreach ($orders as $order) {
      $date = $order->getDate();
      $date = new DateTime($date);
      $formattedDate = $date->format('d-m-Y');

      // Check if the order date is today or later
      if ($date >= $today) {
         if (!isset($groupedOrdersByDate[$formattedDate])) {
            $groupedOrdersByDate[$formattedDate] = [];
         }
         $groupedOrdersByDate[$formattedDate][] = $order;
      } else {
         if (!isset($groupedOrdersByDatePast[$formattedDate])) {
            $groupedOrdersByDatePast[$formattedDate] = [];
         }
         $groupedOrdersByDatePast[$formattedDate][] = $order;
      }
   }

   include('Presentation/specificUserOrders.php');
} catch (noOrdersFoundException) {
   include('Presentation/noOrdersFound.php');
} catch (Exception $e) {
   echo "Something went wrong: " . $e->getMessage();
   exit;
}

include('Presentation/footer.php');
