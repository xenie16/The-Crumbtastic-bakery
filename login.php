<?php

declare(strict_types=1);

spl_autoload_register();
session_start();

use Business\UserService;
use Exceptions\incorrectPasswordException;
use Exceptions\noUserFoundException;
use Exceptions\userBlockedException;

$tabTitle = "Login";
$navLinks = [];
$error = "";
$email = "";
$specificStyling = "loginRegister";
$userId = $_SESSION['id'] ?? null;


// Gets email from cookie
if (isset($_COOKIE['email'])) {
   $email = $_COOKIE['email'];
}

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
      "Sign up" => "register.php"
   ];
}

// Validates login and checks if user is blocked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
   $email = trim(htmlentities($_POST['email'] ?? ''));
   $password = trim(htmlentities($_POST['password'] ?? ''));

   if (!empty($email) && !empty($password)) {
      try {
         $userService = new UserService();
         $user = $userService->getUserThroughLogin($email, sha1($password));
         if ($user) {

            $userId = $user->getId();
            $userService->isUserBlocked($userId);
            $_SESSION['id'] = $userId;
            setcookie("email", $email, time() + 365 * 24 * 60 * 60);

            header("Location: index.php");
            exit;
         }
      } catch (noUserFoundException $e) {
         $error = "No user found with this email";
      } catch (incorrectPasswordException $e) {
         $error = "Incorrect password";
      } catch (userBlockedException) {
         $error = "You have been blocked. Send us an email for more information.";
      } catch (Exception $e) {
         $error = "Something went wrong";
         exit;
      }
   }
}

include('Presentation/header.php');
include('Presentation/loginPage.php');
include('Presentation/footer.php');
