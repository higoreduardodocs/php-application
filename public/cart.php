<?php

include './config.php';
session_start();
$user_id = $_SESSION['user_id'];

if (isset($_POST['update_cart'])) {
  
  $id = $_POST['id'];
  $quantity = $_POST['quantity'];
  mysqli_query($conn, "UPDATE `cart` SET quantity = '$quantity' WHERE id = '$id'") or die('query failed');
  $message[] = 'Cart quantity updated!';

}

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$id'") or die('queyr failed');
  $message[] = 'Delete to cart';
}

if (isset($_GET['delete_all'])) {
  mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
  $message[] = 'Cart empty';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <?php include './header.php'; ?>

  <div class="heading">
    <h3>Shopping cart</h3>
    <p><a href="./index.php">Home</a> / Cart</p>
  </div>

  <section class="shopping-cart">
    <h1 class="title">Products added</h1>

    <div class="box-container">
    <?php
      $total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if (mysqli_num_rows($select_cart) > 0) {
        while ($fetch_cart = mysqli_fetch_assoc($select_cart)){
    ?>
      <div class="box">
        <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('Delete this from cart?');"></a>
        <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="<?php echo $fetch_cart['name']; ?>">
        <span class="product-detail"><?php echo $fetch_cart['name']; ?></span>
        <span class="price">$<?php echo $fetch_cart['price']; ?></span>
        <form method="post">
          <input type="hidden" name="id" value="<?php echo $fetch_cart['id']; ?>" />
          <input type="number" min="1" value="<?php echo $fetch_cart['quantity']; ?>" name="quantity" required class="cart-quantity" />
          <input type="submit" name="update_cart" value="Update" class="btn orange" />
        </form>
        <p class="sub-total">Subtotal: <span>$<?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?></span></p>
      </div>
    <?php
      $total += $sub_total;
      }} else {
        echo '<p class="empty">Your cart is empty</p>';
      }
    ?>
    </div>

    <div style="margin-top: 2rem; text-align:center;">
      <a href="./cart.php?delete_all" class="btn red <?php echo ($total > 1)?'':'disabled'; ?>" onclick="return confirm('Delete all from cart?');">Delete all</a>
    </div>

   <div class="cart-total">
      <p>Total: <span>$<?php echo $total; ?></span></p>
      <a href="./shop.php" class="btn purple">Continue shopping</a>
      <a href="./checkout.php" class="btn orange <?php echo ($total > 1)?'':'disabled'; ?>">Proceed to checkout</a>
   </div>
  </section>

  <?php include './footer.php'; ?>
  <script src="./js/script.js"></script>
</body>
</html>