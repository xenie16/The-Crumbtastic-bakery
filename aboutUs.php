<?php

declare(strict_types=1);

spl_autoload_register();
session_start();

$tabTitle = "About us";
$navLinks = [];
$specificStyling = "aboutUs";
$userId = $_SESSION['id'] ?? null;

// Sets the nav links
if (isset($userId) && $userId != 1) {
   $navLinks = [
      "Shop" => "index.php",
      "My profile" => "profile.php",
      "Log out" => "index.php?action=logout"
   ];
} elseif (isset($userId) && $userId == 1) {
   $navLinks = [
      "Shop" => "index.php",
      "My profile" => "profile.php",
      "Orders" => "orders.php",
      "Customers" => "customers.php",
      "Log out" => "index.php?action=logout",
   ];
} else {
   $navLinks = [
      "Shop" => "index.php",
      "Log in" => "login.php",
      "Sign up" => "register.php"
   ];
}

include('Presentation/header.php');
include('Presentation/aboutUsPage.php');
include('Presentation/footer.php');
