<?php

include '../config.php';
session_start();

$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
  header('location:login.php');
}

if (isset($_POST['update_payment'])) {

  $id = $_POST['id'];
  $payment_status = $_POST['payment_status'];
  mysqli_query($conn, "UPDATE `orders` SET payment_status = '$payment_status' WHERE id = '$id'") or die('query failed');
  $message[] = 'Payment status has been updated!';

}

if (isset($_GET['delete'])) {

  $id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$id'") or die('query failed');
  header('location:./orders.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <?php include './header.php'; ?>

  <section class="orders">
    <h1 class="title">Orders</h1>
    <div class="box-container">
      <?php
        $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
        if(mysqli_num_rows($select_orders) > 0) {
          while($fetch_orders = mysqli_fetch_assoc($select_orders)){
      ?>
      <div class="box">
        <p>User id: <span><?php echo $fetch_orders['user_id']; ?></span></p>
        <p>Placed on: <span><?php echo $fetch_orders['placed_on']; ?></span></p>
        <p>Name: <span><?php echo $fetch_orders['name']; ?></span></p>
        <p>Number: <span><?php echo $fetch_orders['number']; ?></span></p>
        <p>Email: <span><?php echo $fetch_orders['email']; ?></span></p>
        <p>Address: <span><?php echo $fetch_orders['address']; ?></span></p>
        <p>Total products: <span><?php echo $fetch_orders['total_products']; ?></span></p>
        <p>Total price: <span><?php echo $fetch_orders['total_price']; ?></span></p>
        <p>Payment method: <span><?php echo $fetch_orders['method']; ?></span></p>
        <div class="form-container">
          <form method="post">
            <input type="hidden" name="id" value="<?php echo $fetch_orders['id']; ?>" />
            <select name="payment_status" class="box">
              <option value="" disabled selected><?php echo $fetch_orders['payment_status']; ?></option>
              <option value="Pending">Pending</option>
              <option value="Completed">Completed</option>
            </select>
            <input type="submit" name="update_payment" value="Update" class="btn orange" />
            <a href="./orders.php?delete=<?php echo $fetch_orders['id'];?>" onclick="return confirm('Delete this order?');" class="btn red">Delete</a>
          </form>
        </div>
      </div>
      <?php
        }} else {
          echo '<p class="empty">No orders placed yet!</p>';
        } ?>
    </div>
  </section>

  <script src="../js/script.js"></script>
</body>
</html>