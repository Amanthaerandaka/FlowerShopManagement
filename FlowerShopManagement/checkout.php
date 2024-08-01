<?php

include 'includes/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:home.php');
   exit();
}

if (isset($_POST['submit'])) {

   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
   $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
   $method = filter_var($_POST['method'], FILTER_SANITIZE_STRING);
   $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if ($check_cart->rowCount() > 0) {

      if (empty($address)) {
         $message[] = 'Please add your address!';
      } else {

         $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
         $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

         $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
         $delete_cart->execute([$user_id]);

         $message[] = 'Order placed successfully!';
      }

   } else {
      $message[] = 'Your cart is empty!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>

<body>

   <!-- header section starts  -->
   <?php include 'includes/user_header.php'; ?>
   <!-- header section ends -->

   <div class="heading">
      <h3>Checkout</h3>
      <p><a href="home.php">Home</a> <span> / Checkout</span></p>
   </div>

   <section class="checkout">

      <h1 class="title">Order Summary</h1>

      <form method="post">

         <div class="cart-items">
            <h3>Cart Items</h3>
            <?php
            $grand_total = 0;
            $cart_items = [];
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            if ($select_cart->rowCount() > 0) {
               while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                  $cart_items[] = $fetch_cart['name'] . ' (' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity'] . ') - ';
                  $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
                  ?>
                  <p><span class="name"><?= htmlspecialchars($fetch_cart['name']); ?></span> <span class="price">Rs <?= htmlspecialchars($fetch_cart['price']); ?> x <?= htmlspecialchars($fetch_cart['quantity']); ?></span></p>
                  <?php
               }
            } else {
               echo '<p class="empty">Your cart is empty!</p>';
            }
            ?>
            <p class="grand-total"><span class="name">Grand Total:</span><span class="price">Rs <?= htmlspecialchars($grand_total); ?></span></p>
            <a href="cart.php" class="btn">View Cart</a>
         </div>

         <input type="hidden" name="total_products" value="<?= htmlspecialchars(implode('', $cart_items)); ?>">
         <input type="hidden" name="total_price" value="<?= htmlspecialchars($grand_total); ?>">
         
         <!-- Assuming fetch_profile is set somewhere -->
         <?php if (isset($fetch_profile)): ?>
            <input type="hidden" name="name" value="<?= htmlspecialchars($fetch_profile['name']); ?>">
            <input type="hidden" name="number" value="<?= htmlspecialchars($fetch_profile['number']); ?>">
            <input type="hidden" name="email" value="<?= htmlspecialchars($fetch_profile['email']); ?>">
            <input type="hidden" name="address" value="<?= htmlspecialchars($fetch_profile['address']); ?>">
         <?php endif; ?>

         <div class="user-info">
            <h3>Your Info</h3>
            <p><i class="fas fa-user"></i><span><?= htmlspecialchars($fetch_profile['name']); ?></span></p>
            <p><i class="fas fa-phone"></i><span><?= htmlspecialchars($fetch_profile['number']); ?></span></p>
            <p><i class="fas fa-envelope"></i><span><?= htmlspecialchars($fetch_profile['email']); ?></span></p>
            <a href="update_profile.php" class="btn">Update Info</a>
            <h3>Delivery Address</h3>
            <p><i class="fas fa-map-marker-alt"></i><span>
                  <?= empty($fetch_profile['address']) ? 'Please enter your address' : htmlspecialchars($fetch_profile['address']); ?>
               </span></p>
            <a href="update_address.php" class="btn">Update Address</a>
            <select name="method" class="box" required>
               <option value="paytm">cash on delivery</option>
               <!-- Add other payment options if needed -->
            </select>
            <input type="submit" value="Place Order" class="btn <?php if (empty($fetch_profile['address'])) { echo 'disabled'; } ?>" style="width:100%; background:var(--red); color:var(--white);" name="submit">
         </div>

      </form>

   </section>

   <!-- footer section starts  -->
   <?php include 'includes/footer.php'; ?>
   <!-- footer section ends -->

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>
