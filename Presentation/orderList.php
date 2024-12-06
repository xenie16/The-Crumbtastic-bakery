</header>
<main>
   <h1>Order overview</h1>
   <h2 class="status">Ongoing orders</h2>
   <?php foreach ($groupedOrdersByDate as $date => $dateOrders) { ?>
      <section>
         <h3><?= $date ?></h3>
         <?php foreach ($dateOrders as $orderId => $orders) { ?>
            <section>
               <h4>Ordernumber: <?= $orderId ?></h4>
               <?php foreach ($orders as $order) { ?>
                  <p><?= $order->getProductName() ?> (<?= $order->getQuantity() ?>)</p>
               <?php } ?>
            </section>
         <?php } ?>
      </section>
   <?php } ?>
   <h2 class="status">Past orders</h2>
   <?php foreach ($groupedOrdersByDatePast as $date => $dateOrders) { ?>
      <section>
         <h3><?= $date ?></h3>
         <?php foreach ($dateOrders as $orderId => $orders) { ?>
            <section>
               <h4>Ordernumber: <?= $orderId ?></h4>
               <?php foreach ($orders as $order) { ?>
                  <p><?= $order->getProductName() ?> (<?= $order->getQuantity() ?>)</p>
               <?php } ?>
            </section>
         <?php } ?>
      </section>
   <?php } ?>
</main>