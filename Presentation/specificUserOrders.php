</header>
<main>
   <ul>
      <li><a href="profile.php">Check your orders</a></li>
      <li><a href="changePassword.php">Change your password</a></li>
   </ul>
   <h1>Order overview</h1>
   <h2>Ongoing orders</h2>
   <?php foreach ($groupedOrdersByDate as $date => $dateOrders) { ?>
      <section class="order-info">
         <h3>Order date: <?= $date ?></h3>
         <table>
            <thead>
               <tr>
                  <th>Item name</th>
                  <th>Quantity</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($dateOrders as $order) { ?>
                  <tr>
                     <td><?= $order->getProductName() ?></td>
                     <td><?= $order->getQuantity() ?></td>
                  </tr>
               <?php } ?>
            </tbody>
         </table>
         <?php if ($date === $currentDate) { ?>
            <p class="error"><?= $error ?? "" ?></p>
         <?php } ?>
         <form method="post">
            <input type="hidden" name="orderId" value="<?= $order->getId() ?>">
            <input type="submit" name="cancelOrder" value="Cancel order">
         </form>

      </section>
   <?php } ?>

   <h2>Past orders</h2>
   <?php foreach ($groupedOrdersByDatePast as $date => $dateOrders) { ?>
      <section class="order-info">
         <h3>Order date: <?= $date ?></h3>
         <table>
            <thead>
               <tr>
                  <th>Item name</th>
                  <th>Quantity</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($dateOrders as $order) { ?>
                  <tr>
                     <td><?= $order->getProductName() ?></td>
                     <td><?= $order->getQuantity() ?></td>
                  </tr>
               <?php } ?>
            </tbody>
         </table>
         <?php if ($date === $currentDate) { ?>
            <p class="error"><?= $error ?? "" ?></p>
         <?php } ?>
      </section>
   <?php } ?>
</main>