<?php

declare(strict_types=1);

namespace Business;

require 'vendor/autoload.php';


use Data\UserDAO;
use Entities\User;
use Config\EmailConfig;

use Exception;
use Exceptions\EmailExistsException;
use Exceptions\noUserFoundException;
use Exceptions\incorrectPasswordException;
use Exceptions\userBlockedException;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;


class UserService
{
   private UserDAO $userDAO;

   public function __construct()
   {
      $this->userDAO = new UserDAO();
   }

   public function getAllUsers(): array
   {
      $records = $this->userDAO->getAllUsers();
      $users = [];

      foreach ($records as $record) {
         $users[] = new User((int)$record['id'], $record['first_name'], $record['last_name'], $record['email'], $record['password'], $record['street'], $record['house_number'], $record['city'], (int)$record['zip_code'], (int)$record['status_id']);
      }

      return $users;
   }

   private function generatePassword(): string
   {
      $randomString = '';
      for ($i = 0; $i < 6; $i++) {
         if (rand(0, 1) === 0) {
            $randomString .= chr(rand(48, 57));
         } else {
            $randomString .= chr(rand(65, 90));
         }
      }
      return ($randomString);
   }

   public function changePassword(int $userId, string $newPassword): void
   {
      $hashedPassword = sha1($newPassword);
      $this->userDAO->changePassword($userId, $hashedPassword);
   }

   public function createUserAndGetId(string $firstName, string $lastName, string $email, string $street, string $houseNumber, string $city, int $zipCode): ?User
   {
      if ($this->checkIfEmailExists($email) !== '') {
         throw new EmailExistsException('Email already exists');
      }

      $password = $this->generatePassword();
      $this->sendEmail($email, $password, $firstName);

      $hashedPassword = sha1($password);
      $this->userDAO->createUserAndGetId($firstName, $lastName, $email, $hashedPassword, $street, $houseNumber, $city, $zipCode);

      return $this->getUserThroughLogin($email, $hashedPassword);
   }

   private function checkIfEmailExists(string $email): string
   {
      return $this->userDAO->checkIfEmailExists($email);
   }

   public function getUserThroughLogin(string $email, string $password): ?User
   {
      $record = $this->userDAO->getUserThroughLogin($email, $password);
      if ($record === null) {
         $email = $this->checkIfEmailExists($email);
         if ($email === '') {
            throw new noUserFoundException();
         } else {
            throw new incorrectPasswordException();
         }
      }
      $user = new User((int)$record['id'], $record['first_name'], $record['last_name'], $record['email'], $record['password'], $record['street'], $record['house_number'], $record['city'], (int)$record['zip_code'], (int)$record['status_id']);
      return $user;
   }

   public function isUserBlocked(int $userId): ?bool
   {
      if ($this->userDAO->checkUserStatus($userId) == 'blocked') {
         throw new userBlockedException();
      }
      return  null;
   }

   public function updateUserStatus(int $userId, int $statusId): void
   {
      $this->userDAO->updateUserStatus($userId, $statusId);
   }

   private function sendEmail($userEmail, $password, $firstName)
   {
      try {
         $config = EmailConfig::$config;
         $mail = new PHPMailer();

         //Tell PHPMailer to use SMTP
         $mail->isSMTP();

         //Enable SMTP debugging
         //SMTP::DEBUG_OFF = off (for production use)
         //SMTP::DEBUG_CLIENT = client messages
         //SMTP::DEBUG_SERVER = client and server messages
         $mail->SMTPDebug = 0;
         
         $mail->Host = 'smtp.gmail.com';

         //Set the SMTP port number:
         // - 465 for SMTP with implicit TLS, a.k.a. RFC8314 SMTPS or
         // - 587 for SMTP+STARTTLS
         $mail->Port = 465;

         //Set the encryption mechanism to use:
         // - SMTPS (implicit TLS on port 465) or
         // - STARTTLS (explicit TLS on port 587)
         $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

         //Whether to use SMTP authentication
         $mail->SMTPAuth = true;

         //Set AuthType to use XOAUTH2
         $mail->AuthType = 'XOAUTH2';

         //Start Option 1: Use league/oauth2-client as OAuth2 token provider
         //Fill in authentication details here
         //Either the gmail account owner, or the user that gave consent
         $email = $config['email'];
         $clientId = $config['clientId'];
         $clientSecret = $config['clientSecret'];

         //Obtained by configuring and running get_oauth_token.php
         //after setting up an app in Google Developer Console.
         $refreshToken = $config['refreshToken'];

         //Create a new OAuth2 provider instance
         $provider = new Google(
            [
               'clientId' => $clientId,
               'clientSecret' => $clientSecret,
            ]
         );

         //Pass the OAuth provider instance to PHPMailer
         $mail->setOAuth(
            new OAuth(
               [
                  'provider' => $provider,
                  'clientId' => $clientId,
                  'clientSecret' => $clientSecret,
                  'refreshToken' => $refreshToken,
                  'userName' => $email,
               ]
            )
         );
         //End Option 1

         //Set who the message is to be sent from
         $mail->setFrom($email, 'The Crumbtastic Bakery');

         //Set who the message is to be sent to
         $mail->addAddress($userEmail, 'John Doe');
         $mail->Subject = 'Your Password - The Crumbtastic Bakery';

         //Read an HTML message body from an external file, convert referenced images to embedded,
         //convert HTML into a basic plain-text alternative body
         //$mail->CharSet = PHPMailer::CHARSET_UTF8;
         //$mail->msgHTML(file_get_contents('contentsutf8.html'), __DIR__);

         $message = file_get_contents('Presentation\email_template.html');
         $message = str_replace('[User]', $firstName, $message);
         $message = str_replace('[Password]', $password, $message);

         //Replace the plain text body with one created manually
         $mail->Body    = $message;
         $mail->AltBody = 'Your password is: ' . $password;
         //send the message, check for errors
         if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
         } else {
            echo 'Message sent!';
         }

      } catch (Exception $e) {
         echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
         exit;
      }
   }
}
