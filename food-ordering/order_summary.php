<?php
// ================================================================
// ORDER SUMMARY PAGE (order_summary.php)
// ================================================================
// Displays order confirmation after successful order placement
// Shows order ID, items, and total bill
// ================================================================

// Start session
session_start();

// Include database connection file
require_once('db.php');

// ================================================================
// REDIRECT IF NOT LOGGED IN
// ================================================================

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// ================================================================
// GET ORDER ID FROM URL
// ================================================================

if (!isset($_GET['order_id'])) {
    header("Location: index.php");
    exit();
}

$order_id = intval($_GET['order_id']);

// ================================================================
// FETCH ORDER DETAILS FROM DATABASE
// ================================================================

// Query to get order information
$order_query = "SELECT * FROM orders WHERE order_id = '$order_id' AND user_id = '" . $_SESSION['user_id'] . "'";
$order_result = mysqli_query($conn, $order_query);

// Check if order exists
if (mysqli_num_rows($order_result) == 0) {
    header("Location: index.php");
    exit();
}

// Fetch order data
$order = mysqli_fetch_assoc($order_result);

// ================================================================
// FETCH ORDER ITEMS (ORDER DETAILS)
// ================================================================

$order_items_query = "SELECT od.*, f.food_name FROM order_details od 
                     JOIN food f ON od.food_id = f.food_id 
                     WHERE od.order_id = '$order_id'";

$order_items_result = mysqli_query($conn, $order_items_query);

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary - Online Food Ordering System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <h1>🍕 Online Food Ordering System</h1>
        <p>Order Placed Successfully!</p>
    </header>

    <!-- Navigation -->
    <nav>
        <a href="index.php">Menu</a>
        <a href="logout.php">Logout</a>
        <span style="color: white; margin-left: 20px;">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
    </nav>

    <!-- Main Container -->
    <div class="container">
        <div class="section">
            <!-- Success Message -->
            <div class="alert alert-success">
                <h2>✓ Order Confirmed!</h2>
                <p>Your order has been successfully placed and is now being prepared.</p>
            </div>

            <!-- Order Details -->
            <div style="background-color: #f9f9f9; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h3>Order Details</h3>
                
                <div class="cart-summary">
                    <div class="cart-summary-item">
                        <strong>Order ID:</strong>
                        <span style="color: #e74c3c; font-weight: bold;">
                            #<?php echo str_pad($order['order_id'], 5, '0', STR_PAD_LEFT); ?>
                        </span>
                    </div>
                    <div class="cart-summary-item">
                        <strong>Order Date & Time:</strong>
                        <span><?php echo date("d-M-Y H:i", strtotime($order['created_at'])); ?></span>
                    </div>
                    <div class="cart-summary-item">
                        <strong>Order Status:</strong>
                        <span style="background-color: #fff3cd; color: #856404; padding: 5px 10px; border-radius: 5px;">
                            <?php echo htmlspecialchars($order['status']); ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Order Items Table -->
            <h3>Order Items</h3>
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($item = mysqli_fetch_assoc($order_items_result)) {
                        $item_total = $item['price'] * $item['quantity'];
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['food_name']); ?></td>
                            <td>₹<?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>₹<?php echo number_format($item_total, 2); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

            <!-- Bill Summary -->
            <div class="cart-summary">
                <div class="cart-summary-item">
                    <strong>Subtotal:</strong>
                    <span>₹<?php echo number_format($order['total_amount'], 2); ?></span>
                </div>
                <div class="cart-summary-item">
                    <strong>Delivery Charge:</strong>
                    <span>₹0.00</span>
                </div>
                <div class="cart-total">
                    <strong>Total Amount:</strong>
                    <strong>₹<?php echo number_format($order['total_amount'], 2); ?></strong>
                </div>
            </div>

            <!-- Additional Information -->
            <div style="background-color: #d1ecf1; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <h4>📦 What Next?</h4>
                <ul style="margin-left: 20px;">
                    <li>Your order is being prepared in our kitchen</li>
                    <li>Estimated delivery time: 30-45 minutes</li>
                    <li>An SMS notification will be sent when your order is ready</li>
                    <li>Our delivery partner will contact you for delivery</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div style="text-align: center; margin-top: 30px;">
                <a href="index.php" class="btn btn-primary">Continue Shopping</a>
                <a href="logout.php" class="btn btn-danger" style="margin-left: 10px;">Logout</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Online Food Ordering System - All Rights Reserved</p>
    </footer>
</body>
</html>
