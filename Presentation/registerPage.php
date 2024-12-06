</header>
<main class="login-register-page">
   <h1>Register</h1>
   <form class="login-register-form" action="register.php" method="post">
      <label>First name
         <input type="text" name="firstName" required>
      </label>
      <label>Last name
         <input type="text" name="lastName" required>
      </label>
      <label>Street
         <input type="text" name="street" required>
      </label>
      <label>House number
         <input type="text" name="houseNumber" required>
      </label>
      <label>Zip code
         <input type="number" name="zipCode" step="1" required>
      </label>
      <label>City
         <input type="text" name="city" required>
      </label>
      <label>Email
         <input type="email" name="email" required>
      </label>
      <p class="error"><?= $emailError ?></p>
      <input class="submit-button" type="submit" name="submit" value="Create account">
   </form>
</main>