</header>
<main>
   <h1>Login</h1>
   <form class="login-register-form" action="login.php" method="post">
      <label>Email
         <input type="email" name="email" value="<?= $email ?>" required>
      </label>
      <label>Password
         <input type="password" name="password" required>
      </label>
      <p class="error"><?= $error ?></p>
      <input class="submit-button" type="submit" name="submit" value="Log in">
   </form>
</main>