<?php

declare(strict_types=1);

spl_autoload_register();
session_start();

use Business\OrderService;
use Business\CartService;
use Exceptions\dateAlreadyExistsException;

$tabTitle = "Payment";
$navLinks = [];
$specificStyling = "orderConfirmation";
$userId = $_SESSION['id'] ?? null;
$minDate = date('Y-m-d', strtotime('+1 day'));
$maxDate = date('Y-m-d', strtotime('+3 days'));

// Sets the nav links
if (isset($userId) && $userId != 1) {
   $navLinks = [
      "Shop" => "index.php",
      "About us" => "aboutUs.php",
      "My profile" => "profile.php",
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
   header("Location: login.php");
   exit();
}

$cartService = new CartService();

// Confirms order, removes products from cart and moves them to order
if (isset($_POST['submit'])) {
   try {
      $orderService = new OrderService();
      $date = $_POST['pickup_date'];
      $dateObject = new DateTime($date);
      $formattedDate = $dateObject->format('d/m');

      $products = $orderService->moveFromCartToOrder($userId, $date);
      $cartService->removeAllProductsFromCart($userId);
      header("Location: profile.php");
      exit;
   } catch (dateAlreadyExistsException) {
      $error = "You have already placed an order for this day. Please choose another date.";
   } catch (Exception) {
      print "Something went wrong";
      exit;
   }
}

include('Presentation/header.php');
try {
   $products = $cartService->getAllCartProductsByUserId($userId);
   $totalPrice = $cartService->getCartTotalPriceByUserId($userId);
   include('Presentation/confirmOrderPage.php');
} catch (Exception) {
   print "Something went wrong";
   exit;
}
include('Presentation/footer.php');
