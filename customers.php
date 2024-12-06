<?php

declare(strict_types=1);

spl_autoload_register();
session_start();

use Business\UserService;
use Business\StatusService;

$tabTitle = "Customers";
$specificStyling = "customers";
$userId = $_SESSION['id'] ?? null;
$navLinks = [];

// Sets the nav links
if (isset($userId) && $userId != 1) {
   header("Location: index.php");
   exit();
} elseif (isset($userId) && $userId == 1) {
   $navLinks = [
      "Shop" => "index.php",
      "About us" => "aboutUs.php",
      "My profile" => "profile.php",
      "Orders" => "orders.php",
      "Log out" => "index.php?action=logout"
   ];
} else {
   header("Location: index.php");
   exit();
}

// Get all users
$userService = new UserService();
$statusService = new StatusService();

$users = $userService->getAllUsers();
$statuses = $statusService->getAllStatuses();

// Update user status
if (isset($_POST['updateButton'])) {
   $userId = $_POST['userId'];
   $statusId = $_POST['statusId'];
   $userService->updateUserStatus((int)$userId, (int)$statusId);
   header("Location: customers.php");
   exit();
}

include('Presentation/header.php');
include('Presentation/customerList.php');
include('Presentation/footer.php');
