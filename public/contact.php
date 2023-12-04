<?php

include './config.php';
session_start();

if(isset($_POST['send'])){
  $user_id = $_SESSION['user_id'];
  if (!isset($user_id)) {
    header('location:./login.php');
  }

  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $number = $_POST['number'];
  $msg = mysqli_real_escape_string($conn, $_POST['message']);

  $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

  if(mysqli_num_rows($select_message) > 0){
    $message[] = 'Message sent already!';
  }else{
    mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
    $message[] = 'Message sent successfully!';
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <?php include './header.php'; ?>

  <div class="heading">
    <h3>Contact us</h3>
    <p><a href="./index.php">Home</a> / Contact</p>
  </div>

  <section class="contact form-container">
    <form method="post">
      <h3>Say something</h3>
      <input type="text" name="name" required placeholder="Enter your name" class="box" />
      <input type="email" name="email" required placeholder="Enter your email" class="box" />
      <input type="number" name="number" required placeholder="Enter your number" class="box" />
      <textarea name="message" cols="30" rows="10" class="box" placeholder="Enter your message" required></textarea>
      <input type="submit" value="Send message" name="send" class="btn purple" />
    </form>
  </section>

  <?php include './footer.php'; ?>
  <script src="./js/script.js"></script>
</body>
</html>