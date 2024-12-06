<img id="banner" src="Presentation\img\banner.jpg"><img>
</header>
<main>
   <h1>Our products</h1>

   <section class="products-grid">
      <?php foreach ($products as $product) { ?>
         <div class="product">
            <img src="Presentation\img\productImg\<?= $product->getImg() ?>" alt="<?= $product->getName() ?>">
            <div class="product-details">
               <p><?= $product->getName() ?></p>
               <p class="price">€<?= $product->getFormattedPrice() ?></p>
               <form action="<?= $redirectLink ?>" method="post">
                  <input type="hidden" name="productId" value="<?= $product->getId() ?>">
                  <input class="submit-button" type="submit" name="viewProduct" value="<?= $productText ?>">
               </form>
            </div>
         </div>
      <?php } ?>
   </section>
</main>