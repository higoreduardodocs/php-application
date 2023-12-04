<?php

include './config.php';
session_start();
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
  header('location:./login.php');
}

if (isset($_POST['checkout'])) {

  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $number = $_POST['number'];
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $method = mysqli_real_escape_string($conn, $_POST['method']);
  $address = mysqli_real_escape_string($conn, 'flat no. '. $_POST['flat'].', '. $_POST['street'].', '. $_POST['city'].', '. $_POST['country'].' - '. $_POST['pincode']);
  $placed_on = date('d-M-Y');

  $total_price = 0;
  $cart_products[] = '';

  $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
  if(mysqli_num_rows($cart_query) > 0){
    while($cart_item = mysqli_fetch_assoc($cart_query)){
       $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
       $sub_total = ($cart_item['price'] * $cart_item['quantity']);
       $total_price += $sub_total;
    }
  }

  $total_products = implode(', ', $cart_products);

  $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$total_price'") or die('query failed');

  if($total_price == 0){
    $message[] = 'Your cart is empty';
  }else{
    if(mysqli_num_rows($order_query) > 0){
      $message[] = 'Order already placed!'; 
    } else {
      mysqli_query($conn, "INSERT INTO `orders` (user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$total_price', '$placed_on')") or die('query failed');
      $message[] = 'Order placed successfully!';
      mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    }
  }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <?php include './header.php'; ?>

  <div class="heading">
    <h3>Checkout</h3>
    <p><a href="./index.php">Home</a> / Checkout </p>
  </div>

  <div class="cart-list">
    <?php
      $total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if (mysqli_num_rows($select_cart) > 0) {
        while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
          $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']);
          $total += $sub_total;
    ?>
    <p>
      <?php echo $fetch_cart['name']; ?>
      <span>(<?php echo '$'.$fetch_cart['price'].' x '. $fetch_cart['quantity']; ?>)</span>
    </p>
    <?php
      }} else {
        echo '<p class="empty">Your cart is empty</p>';
      }
    ?>
    <div>Total: <span>$<?php echo $total; ?></span></div>
  </div>

  <section class="checkout form-container">
    <form method="post">
      <h3>place your order</h3>
      <div>
        <div class="input-box">
          <label for="name">Your name:</label>
          <input type="text" id="name" name="name" required placeholder="Enter your name" class="box" />
        </div>
        <div class="input-box">
          <label for="email">Your email:</label>
          <input type="text" id="email" name="email" required placeholder="Enter your email" class="box" />
        </div>
        <div class="input-box">
          <label for="number">Your number:</label>
          <input type="number" id="number" name="number" required placeholder="Enter your number" class="box" />
        </div>
        <div class="input-box">
          <label for="payment">Payment method:</label>
          <select name="method" id="payment" class="box">
            <option value="cash-on-delivery">Cash on delivery</option>
            <option value="credit-card">Credit card</option>
            <option value="paypal">Paypal</option>
            <option value="paytm">Paytm</option>
          </select>
        </div>
        <div class="input-box">
          <label for="address-number">Your address number</label>
          <input type="number" id="address-number" min="0" name="flat" required placeholder="Enter your address number" class="box" />
        </div>
        <div class="input-box">
          <label for="street">Your street</label>
          <input type="text" id="street" name="street" required placeholder="Enter your street name" class="box" />
        </div>
        <div class="input-box">
          <label for="city">Your city</label>
          <input type="text" id="city" name="city" required placeholder="Enter your city" class="box" />
        </div>
        <div class="input-box">
          <label for="state">Your state</label>
          <input type="text" id="state" name="state" required placeholder="Enter your state" class="box" />
        </div>
        <div class="input-box">
          <label for="country">Your country</label>
          <input type="text" id="country" name="country" required placeholder="Enter your country" class="box" />
        </div>
        <div class="input-box">
          <label for="pincode">Your pincode</label>
          <input type="text" id="pincode" name="pincode" required placeholder="Enter your pincode" class="box" />
        </div>
      </div>
      <input type="submit" name="checkout" value="Order now" class="btn orange" />
    </form>
  </section>

  <?php include './footer.php'; ?>
  <script src="./js/script.js"></script>
</body>
</html>