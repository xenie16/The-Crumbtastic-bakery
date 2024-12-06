</header>
<main class="confirm-order-page">
   <h1>Confirm Your Order</h1>

   <section class="order-items">
      <h2>Order Items</h2>

      <?php foreach ($products as $product) { ?>
         <div class="order-item order-details">
            <p class="item-name"><?= $product->getProductName() ?></p>
            <p class="item-quantity">Quantity: <?= $product->getQuantity() ?></p>
            <p class="item-total-price">Total: € <?= $product->getTotalPrice() ?></p>
         </div>
      <?php } ?>
      <p>Total Price: € <?= $totalPrice ?></p>
   </section>

   <section class="pickup-date">
      <h2>Select Pickup Date</h2>
      <form method="post">
         <label for="pickup-date">Pickup Date:</label>
         <input type="date" name="pickup_date" min="<?= $minDate ?>" max="<?= $maxDate  ?>" required>
         <p class="error"><?= $error ?? "" ?></p>
         <input type="submit" name="submit" value="Place order">
      </form>
      <a href="basket.php"><button>Return</button></a>
   </section>
</main>