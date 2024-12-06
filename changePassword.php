<?php

declare(strict_types=1);

spl_autoload_register();
session_start();

use Business\UserService;

$tabTitle = "My profile";
$navLinks = [];
$userId = $_SESSION['id'] ?? null;
$specificStyling = "changePassword";

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

// Change password
if (isset($_POST['oldPassword']) && isset($_POST['newPassword']) && isset($_POST['confirmNewPassword'])) {

   $oldPassword = $_POST['oldPassword'];
   $newPassword = $_POST['newPassword'];
   $confirmNewPassword = $_POST['confirmNewPassword'];

   if ($newPassword !== $confirmNewPassword) {
      $error = "Passwords do not match.";
   } elseif ($oldPassword === $newPassword) {
      $error = "New password must be different from old password.";
   } else {
      $userService = new UserService();
      $userService->changePassword($userId, $newPassword);

      header("Location: profile.php");
      exit();
   }
}

include('Presentation/header.php');
include('Presentation/changePassword.php');
include('Presentation/footer.php');
