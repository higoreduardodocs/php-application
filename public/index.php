<?php

include './config.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <?php include './header.php'; ?>

  <section class="home">
    <div class="content">
      <h3>Hand Picked Book to your door.</h3>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi, quod? Reiciendis ut porro iste totam.</p>
      <a href="./about.php" class="btn purple">Discover more</a>
    </div>
  </section>

  <section class="products">
    <h1 class="title">Latest products</h1>
    <div class="box-container">
      <?php
        $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
        if (mysqli_num_rows($select_products) > 0) {
          while ($fetch_products = mysqli_fetch_assoc($select_products)) {
      ?>
      <form method="post" class="box">
        <img src="./uploaded_img/<?php echo $fetch_products['image']; ?>" alt="<?php echo $fetch_products['name']; ?>" />
        <span class="product-detail"><?php echo $fetch_products['name']; ?></span>
        <span class="price">$<?php echo $fetch_products['price']; ?></span>
        <input type="number" min="1" value="1" name="quantity" required class="cart-quantity" />
        <input type="hidden" name="name" value="<?php echo $fetch_products['name']; ?>" />
        <input type="hidden" name="price" value="<?php echo $fetch_products['price']; ?>" />
        <input type="hidden" name="image" value="<?php echo $fetch_products['image']; ?>" />
        <input type="submit" name="add_cart" value="Add to cart" class="btn orange" />
      </form>
      <?php
        }} else {
          echo '<p class="empty">No products added yet!</p>';
        }
      ?>
    </div>
    <div style="margin-top: 2rem; text-align:center">
      <a href="shop.php" class="btn purple">Load more</a>
    </div>
  </section>

  <section class="about">
    <div class="image">
      <img src="./images/about-img.jpg" alt="About" />
    </div>
    <div class="content">
      <h3>About us</h3>
      <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit quos enim minima ipsa dicta officia corporis ratione saepe sed adipisci?</p>
      <a href="./about.php" class="btn purple">Read more</a>
    </div>
  </section>

  <section class="home-contact">
    <div class="content">
      <h3>Have any questions?</h3>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque cumque exercitationem repellendus, amet ullam voluptatibus?</p>
      <a href="./contact.php" class="btn orange">Contact us</a>
    </div>
  </section>
  
  <?php include './footer.php'; ?>
  <script src="./js/script.js"></script>
</body>
</html>