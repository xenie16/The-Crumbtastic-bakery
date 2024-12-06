<?php

declare(strict_types=1);

spl_autoload_register();
session_start();

use Business\ProductService;
use Business\CartService;

use Exceptions\noProductsFoundException;

$tabTitle = "";
$specificStyling = "specificProduct";
$userId = $_SESSION['id'] ?? null;
$navLinks = [];
$productId = (int)$_POST['productId'];
$message = "";

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
   header("Location: index.php");
   exit();
}

// Redirects to login if user is not logged in and tries to view product
if (isset($_POST['viewProduct']) && $_POST['viewProduct'] == "Log in to add to basket") {
   header("Location: login.php");
   exit();
}

// Gets specific product by product id
try {
   $productService = new ProductService();
   $product = $productService->getProductById($productId);
   $tabTitle = $product->getName();
} catch (noProductsFoundException) {
   print "This product wasn't found";
} catch (Exception) {
   print "Something went wrong";
}

// Adds product to cart
if (isset($_POST['addToCart'])) {
   $cartService = new CartService();
   $cartService->insertIntoCart((int)$_SESSION['id'], (int)$productId, (int)$_POST['quantity']);
   $message = "Added to basket";
}

include('Presentation/header.php');
include('Presentation/showSpecificProduct.php');
include('Presentation/footer.php');
