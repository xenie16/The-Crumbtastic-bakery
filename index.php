<?php

declare(strict_types=1);

spl_autoload_register();
session_start();

use Business\ProductService;
use Exceptions\noProductsFoundException;

$tabTitle = "Products";
$specificStyling = "allProducts";
$navLinks = [];
$productText = "";
$userId = $_SESSION['id'] ?? null;

function logout() {
   session_destroy();
   header("Location: index.php");
   exit;
}

// Logout if logout button is clicked
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
   logout();
}

// Sets the nav links
if (isset($userId) && $userId != 1) {
   $navLinks = [
      "About us" => "aboutUs.php",
      "My profile" => "profile.php",
      "Log out" => "index.php?action=logout"
   ];
   $redirectLink = "product.php";
   $productText = "Buy product";
} elseif (isset($userId) && $userId == 1) {
   $navLinks = [
      "About us" => "aboutUs.php",
      "My profile" => "profile.php",
      "Orders" => "orders.php",
      "Customers" => "customers.php",
      "Log out" => "index.php?action=logout",
   ];
   $redirectLink = "product.php";
   $productText = "Buy product";
} else {
   $navLinks = [
      "About us" => "aboutUs.php",
      "Log in" => "login.php",
      "Sign up" => "register.php"
   ];
   $redirectLink = "login.php";
   $productText = "Log in to add to basket";
}

// Gets all products
try {
   $productService = new ProductService();
   $products = $productService->getAllProducts();
} catch (noProductsFoundException) {
   print "No products found";
   exit;
} catch (Exception) {
   print "Something went wrong";
   exit;
}

include('Presentation/header.php');
include('Presentation/showAllProducts.php');
include('Presentation/footer.php');
