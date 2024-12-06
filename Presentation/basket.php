</header>
<main class="basket-page">
   <h1>Basket <span><?= $totalItems ?> items</span></h1>

   <?php foreach ($products as $product) { ?>
      <section class="basket-item">
         <img src="Presentation/img/productImg/<?= $product->getImg() ?>" alt="<?= $product->getProductName() ?>">
         <div class="item-details">
            <p class="item-name"><?= $product->getProductName() ?></p>
            <p class="price">€<?= $product->getFormattedPrice() ?> / piece</p>
            <form method="post">
               <label>Quantity:
                  <input class="item-quantity" type="number" name="quantity" value="<?= $product->getQuantity() ?>" min="1">
               </label>
               <input type="hidden" name="productId" value="<?= $product->getProductId() ?>">
               <input type="submit" name="updateQuantity" value="Update quantity">
               <input type="submit" name="remove" value="Remove">
            </form>
         </div>
         <p class="price">€<?= $product->getFormattedTotal() ?></p>
      </section>
   <?php } ?>

   <section class="order-summary">
      <div class="summary-details">
         <p>Order summary</p>
         <p>Total: €<?= $totalPrice ?></p>
      </div>
      <a href="confirmOrder.php"><button>Continue to confirm order</button></a>
   </section>
</main>