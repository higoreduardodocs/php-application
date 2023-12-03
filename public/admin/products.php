<?php

include '../config.php';
session_start();

$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
  header('location:login.php');
}

if(isset($_POST['add'])) {

  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $price = $_POST['price'];
  $image = $_FILES['image']['name'];
  $image_size = $_FILES['image']['size'];
  $image_tmp_name = $_FILES['image']['tmp_name'];
  $image_folder = '../uploaded_img/'.$image;

  if ($image_size > 2000000) {
    $message[] = 'Image size is too large';
  } else {

    $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');

    if(mysqli_num_rows($select_product_name) > 0) {
      $message[] = 'Product name already added';
    } else {
      $add_product = mysqli_query($conn, "INSERT INTO `products` (name, price, image) VALUES ('$name', '$price', '$image')") or die('query failed');

      if ($add_product) {
        move_uploaded_file($image_tmp_name, $image_folder);
        $message[] = 'Product added successfully!';
      } else {
        $message[] = 'Product could not be added';
      }
    }
  }

}

if (isset($_POST['update'])) {

  $id = $_POST['id'];
  $name = $_POST['name'];
  $price = $_POST['price'];
  $old_image = $_POST['old_image'];

  $image = $_FILES['image']['name'];
  $image_size = $_FILES['image']['size'];
  $image_tmp_name = $_FILES['image']['tmp_name'];
  $image_folder = '../uploaded_img/'.$image;

  $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE id != '$id' AND name = '$name'") or die('query failed');

  if(mysqli_num_rows($select_product_name) > 0) {
    $message[] = 'Product name already added';
  } else {
    mysqli_query($conn, "UPDATE `products` SET name = '$name', price = '$price' WHERE id = '$id'") or die('query failed');

    if (!empty($image)) {
      if ($image_size > 2000000) {
        $message[] = 'Image size is too large';
      } else {
        mysqli_query($conn, "UPDATE `products` SET image = '$image' WHERE id = '$id'") or die('query failed');
        move_uploaded_file($image_tmp_name, $image_folder);
        unlink('../uploaded_img/'.$old_image);
      }
    }
  }

  header('location:./products.php');

}

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$id'") or die('query failed');
  $image = mysqli_fetch_assoc($image_query);
  unlink('../uploaded_img/'.$image['image']);
  mysqli_query($conn, "DELETE FROM `products` WHERE id = '$id'") or die('query failed');
  header('location:./products.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <?php include './header.php'; ?>

  <section>
    <h1 class="title">Shop products</h1>
    <div class="form-container">
      <form method="post" class="add-products" enctype="multipart/form-data">
        <h3>Add product</h3>
        <input type="text" name="name" placeholder="Enter product name" required class="box" />
        <input type="number" min="0" name="price" placeholder="Enter product price" required class="box" />
        <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" required class="box" />
        <input type="submit" name="add" value="Add product" class="btn purple" />
      </form>
    </div>
  </section>

  <section>
    <h1 class="title">Product list</h1>
    <div class="box-container">
      <?php
        $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
        if (mysqli_num_rows($select_products) > 0) {
          while ($fetch_products = mysqli_fetch_assoc($select_products)) {
      ?>
      <div class="box">
        <img src="../uploaded_img/<?php echo $fetch_products['image']; ?>" alt="<?php echo $fetch_products['name']; ?>" />
        <span class="product-detail"><?php echo $fetch_products['name']; ?></span>
        <span class="product-detail">$<?php echo $fetch_products['price']; ?></span>
        <a href="./products.php?update=<?php echo $fetch_products['id']; ?>" class="btn orange">Update</a>
        <a href="./products.php?delete=<?php echo $fetch_products['id']; ?>" class="btn red">Delete</a>
      </div>
      <?php
        }} else {
          echo '<p class="empty">No products added yet!</p>';
        }
      ?>
    </div>
  </section>

  <section class="modal">
    <?php
      if (isset($_GET['update'])) {
        $update_id = $_GET['update'];
        $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('query failed');
        if(mysqli_num_rows($update_query) > 0) {
          while($fetch_update = mysqli_fetch_assoc($update_query)) {
    ?>
    <div class="form-container">
      <form method="post" class="add-products" enctype="multipart/form-data">
        <img src="../uploaded_img/<?php echo $fetch_update['image']; ?>" alt="<?php echo $fetch_update['name']; ?>" />
        <input type="text" name="name" placeholder="Enter product name" value="<?php echo $fetch_update['name']; ?>" required class="box" />
        <input type="number" min="0" name="price" placeholder="Enter product price" value="<?php echo $fetch_update['price']; ?>" required class="box" />
        <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" />
        <input type="submit" name="update" value="Update" class="btn purple" />
        <input type="reset" name="cancel" value="Cancel" class="btn red" onclick="location.replace('./products.php')" />
        <input type="hidden" name="id" value="<?php echo $fetch_update['id']; ?>" />
        <input type="hidden" name="old_image" value="<?php echo $fetch_update['image']; ?>" />
      </form>
    </div>
    <?php
      }}} else {
        echo '<script>document.querySelector(".modal").style.display = "none";</script>';
      }
    ?>
  </section>

  <script src="../js/script.js"></script>
</body>
</html>