<?php

include '../config.php';
session_start();

$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
  header('location:login.php');
}

if (isset($_GET['delete'])) {

  $id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM `message` WHERE id = '$id'") or die('query failed');
  header('location:./messages.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Messages</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <?php include './header.php'; ?>

  <section>
    <h1 class="title">Messages</h1>
    <div class="box-container">
    <?php
      $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
      if(mysqli_num_rows($select_message) > 0){
        while($fetch_message = mysqli_fetch_assoc($select_message)){
    ?>
    <div class="box">
      <p>User id: <span><?php echo $fetch_message['user_id']; ?></span></p>
      <p>Name: <span><?php echo $fetch_message['name']; ?></span></p>
      <p>Number: <span><?php echo $fetch_message['number']; ?></span></p>
      <p>Email: <span><?php echo $fetch_message['email']; ?></span></p>
      <p>Message: <span><?php echo $fetch_message['mesage']; ?></span></p>
      <a href="./messages.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('Delete this message?');" class="btn red">Delete</a>
   </div>
    <?php
        }} else {
          echo '<p class="empty">You have no messages!</p>';
        }
      ?>
    </div>
  </section>

  <script src="../js/script.js"></script>
</body>
</html>