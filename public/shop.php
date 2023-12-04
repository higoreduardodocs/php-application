<?php

include './config.php';
session_start();

if (isset($_POST['add_cart'])) {

  $user_id = $_SESSION['user_id'];

  if (!isset($user_id)) {
    header('location:./login.php');
  }

  $name = $_POST['name'];
  $price = $_POST['price'];
  $quantity = $_POST['quantity'];
  $image = $_POST['image'];

  $check_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$name' AND user_id = '$user_id'") or die('query failed');

  if (mysqli_num_rows($check_cart) > 0) {
    $message[] = 'Already added to cart!';
  } else {
    mysqli_query($conn, "INSERT INTO `cart` (user_id, name, price, quantity, image) VALUES ('$user_id', '$name', '$price', '$quantity', '$image')") or die('query failed');
    $message[] = 'Product added to cart';
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <?php include './header.php'; ?>

  <div class="heading">
    <h3>Our shop</h3>
    <p><a href="./index.php">Home</a> / Shop</p>
  </div>

  <section class="products">
    <h1 class="title">Latest products</h1>
    <div class="box-container">
      <?php
        $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
        if (mysqli_num_rows($select_products) > 0) {
          while($fetch_products = mysqli_fetch_assoc($select_products)) {
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
  </section>

  <?php include './footer.php'; ?>
  <script scr="./js/script.js"></script>
</body>
</html>