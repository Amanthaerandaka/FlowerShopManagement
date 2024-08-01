<?php

include '../includes/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit();
}

if (isset($_POST['update_payment'])) {
    // Check if 'payment_status' and 'order_id' are set
    if (isset($_POST['payment_status']) && isset($_POST['order_id'])) {
        $order_id = $_POST['order_id'];
        $payment_status = $_POST['payment_status'];

        // Ensure 'payment_status' is a valid value
        $valid_statuses = ['pending', 'completed'];
        if (in_array($payment_status, $valid_statuses)) {
            $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
            $update_status->execute([$payment_status, $order_id]);
            $message[] = 'Payment status updated!';
        } else {
            $message[] = 'Invalid payment status!';
        }
    } else {
        $message[] = 'Payment status or Order ID is missing!';
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
    $delete_order->execute([$delete_id]);
    header('location:placed_orders.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placed Orders</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../includes/admin_header.php'; ?>

<!-- Placed Orders Section Starts -->

<section class="placed-orders">

    <h1 class="heading">Placed Orders</h1>

    <div class="box-container">
    <?php
        $select_orders = $conn->prepare("SELECT * FROM `orders`");
        $select_orders->execute();
        if ($select_orders->rowCount() > 0) {
            while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <div class="box">
        <p> User ID: <span><?= htmlspecialchars($fetch_orders['user_id']); ?></span> </p>
        <p> Placed On: <span><?= htmlspecialchars($fetch_orders['placed_on']); ?></span> </p>
        <p> Name: <span><?= htmlspecialchars($fetch_orders['name']); ?></span> </p>
        <p> Email: <span><?= htmlspecialchars($fetch_orders['email']); ?></span> </p>
        <p> Number: <span><?= htmlspecialchars($fetch_orders['number']); ?></span> </p>
        <p> Address: <span><?= htmlspecialchars($fetch_orders['address']); ?></span> </p>
        <p> Total Products: <span><?= htmlspecialchars($fetch_orders['total_products']); ?></span> </p>
        <p> Total Price: <span>Rs<?= htmlspecialchars($fetch_orders['total_price']); ?>/-</span> </p>
        <p> Payment Method: <span>Cash on Delivery</span> </p>
        <form action="" method="POST">
            <input type="hidden" name="order_id" value="<?= htmlspecialchars($fetch_orders['id']); ?>">
            <select name="payment_status" class="drop-down">
                <option value="" selected disabled><?= htmlspecialchars($fetch_orders['payment_status']); ?></option>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
            </select>
            <div class="flex-btn">
                <input type="submit" value="Update" class="btn" name="update_payment">
                <a href="placed_orders.php?delete=<?= htmlspecialchars($fetch_orders['id']); ?>" class="delete-btn" onclick="return confirm('Delete this order?');">Delete</a>
            </div>
        </form>
    </div>
    <?php
            }
        } else {
            echo '<p class="empty">No orders placed yet!</p>';
        }
    ?>
    </div>

</section>

<!-- Placed Orders Section Ends -->

<!-- Custom JS File Link -->
<script src="../js/admin_script.js"></script>

</body>
</html>
