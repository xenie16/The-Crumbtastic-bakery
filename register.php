<?php

declare(strict_types=1);

spl_autoload_register();
session_start();


use Business\UserService;
use Exceptions\EmailExistsException;

$tabTitle = "Register";
$specificStyling = "loginRegister";
$emailError = "";
$userId = $_SESSION['id'] ?? null;
$navLinks = [];

// Sets the nav links
if (isset($userId) && $userId != 1) {
   header("Location: index.php");
   exit;
} elseif (isset($userId) && $userId == 1) {
   header("Location: index.php");
   exit;
} else {
   $navLinks = [
      "Shop" => "index.php",
      "About us" => "aboutUs.php",
      "Log in" => "login.php",
   ];
}

// Create user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
   $fields = ['firstName', 'lastName', 'email', 'street', 'houseNumber', 'zipCode', 'city'];
   foreach ($fields as $field) {
      //$$ is used to create dynamic variables based on the values in the $field array
      $$field = trim(htmlentities($_POST[$field] ?? ''));
   }

   // Validate email
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailError = "Invalid email";
      return;
   }

   // Create user and get id if all fields are not empty
   if (
      !empty($firstName) &&
      !empty($lastName) &&
      !empty($email) &&
      !empty($street) &&
      !empty($houseNumber) &&
      !empty($zipCode) &&
      !empty($city)
   ) {
      try {
         $userService = new UserService();
         $user = $userService->createUserAndGetId($firstName, $lastName, $email, $street, $houseNumber, $city, (int)$zipCode);

         $_SESSION['id'] = $user->getId();

         setcookie("email", $email, time() + 365 * 24 * 60 * 60);

         header("Location: index.php");
         exit;
      } catch (EmailExistsException) {
         $emailError = "Email already exists";
      } catch (Exception) {
         "Something went wrong";
      }
   }
}

include('Presentation/header.php');
include('Presentation/registerPage.php');
include('Presentation/footer.php');
