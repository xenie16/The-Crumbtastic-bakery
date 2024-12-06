</header>
<main>
   <ul>
      <li><a href="profile.php">Check your orders</a></li>
      <li><a href="profile.php?action=changePassword">Change your password</a></li>
   </ul>
   <h1>Change password</h1>

   <form class="login-register-form" action="changePassword.php" method="post">
      <label>Old password
         <input type="password" name="oldPassword" required>
      </label>
      <label>New password
         <input type="password" name="newPassword" required>
      </label>
      <label>Confirm new password
         <input type="password" name="confirmNewPassword" required>
      </label>
      <input class="submit-button" type="submit" name="submit" value="Change password">
   </form>
   <p class="error"><?= $error ?? "" ?></p>
</main>