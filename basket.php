<?php

declare(strict_types=1);

spl_autoload_register();
session_start();

use Business\CartService;

$tabTitle = "Basket";
$navLinks = [];
$userId = $_SESSION['id'] ?? null;
$emptyBasket = false;
$specificStyling = "basket";
$totalItems = 0;


$cartService = new CartService();

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

// Gets all products in cart
try {
   $products = $cartService->getAllCartProductsByUserId($userId);
   $totalPrice = $cartService->getCartTotalPriceByUserId($userId);
   $totalItems = count($products);

   if (empty($products)) {
      $emptyBasket = true;
   }
} catch (Exception) {
   print "Something went wrong";
   exit;
}

// Adds or removes product from cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $productId = isset($_POST['productId']) ? (int)$_POST['productId'] : null;

   if ($productId) {
      if (isset($_POST['updateQuantity'])) {
         $quantity = (int)$_POST['quantity'];
         $cartService->updateCartQuantity($userId, $productId, $quantity);
      } elseif (isset($_POST['remove'])) {
         $cartService->removeProductFromCart($userId, $productId);
      }

      header("Location: basket.php");
      exit();
   }
}

include('Presentation/header.php');
if ($emptyBasket) {
   include('Presentation/emptyBasket.php');
} else {
   include('Presentation/basket.php');
}
include('Presentation/footer.php');
