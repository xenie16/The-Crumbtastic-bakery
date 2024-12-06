</header>
<main class="product-page">
   <img src="Presentation\img\productImg\<?= $product->getImg() ?>" alt="<?= $product->getName() ?>">
   <div class="product-details">
      <h1><?= $product->getName() ?></h1>
      <p><?= $product->getDescription() ?></p>

      <p class="price">€<?= $product->getFormattedPrice() ?></p>

      <form action="product.php" method="post">
         <label>Quantity:
            <input type="number" name="quantity" value="1" min="1" step="1" required>
         </label>
         <input type="hidden" name="productId" value="<?= $product->getId() ?>">
         <input type="submit" name="addToCart" value="Add to basket">
      </form>
      <p class="productAdded"><?= $message ?></p>
   </div>
</main>