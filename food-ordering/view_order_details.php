<?php
// ================================================================
// VIEW ORDER DETAILS (view_order_details.php)
// ================================================================
// Displays detailed information about a specific order
// Shows items, quantities, and total amount
// ================================================================

// Start session
session_start();

// Include database connection file
require_once('db.php');

// ================================================================
// CHECK IF ADMIN IS LOGGED IN
// ================================================================

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin.php");
    exit();
}

// ================================================================
// GET ORDER ID FROM URL
// ================================================================

if (!isset($_GET['order_id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$order_id = intval($_GET['order_id']);

// ================================================================
// FETCH ORDER DETAILS
// ================================================================

// Query to get order information
$order_query = "SELECT o.*, u.name, u.email FROM orders o 
               JOIN users u ON o.user_id = u.user_id 
               WHERE o.order_id = '$order_id'";

$order_result = mysqli_query($conn, $order_query);

// Check if order exists
if (mysqli_num_rows($order_result) == 0) {
    header("Location: admin_dashboard.php");
    exit();
}

// Fetch order data
$order = mysqli_fetch_assoc($order_result);

// ================================================================
// FETCH ORDER ITEMS
// ================================================================

// Query to get items in this order
$items_query = "SELECT od.*, f.food_name FROM order_details od 
               JOIN food f ON od.food_id = f.food_id 
               WHERE od.order_id = '$order_id'";

$items_result = mysqli_query($conn, $items_query);

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Online Food Ordering System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <h1>🍕 Online Food Ordering System - Admin Panel</h1>
        <p>Order Details</p>
    </header>

    <!-- Navigation -->
    <nav>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="add_food.php">Add Food Item</a>
        <a href="view_food.php">Manage Food Items</a>
        <a href="admin_logout.php">Logout</a>
        <span style="color: white; margin-left: 20px;">👨‍💼 Admin Panel</span>
    </nav>

    <!-- Main Container -->
    <div class="container">
        <div class="section">
            <h2>Order Details - Order #<?php echo str_pad($order['order_id'], 5, '0', STR_PAD_LEFT); ?></h2>

            <!-- Order Information -->
            <div style="background-color: #f9f9f9; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h3>Order Information</h3>
                
                <div class="cart-summary">
                    <div class="cart-summary-item">
                        <strong>Order ID:</strong>
                        <span>#<?php echo str_pad($order['order_id'], 5, '0', STR_PAD_LEFT); ?></span>
                    </div>
                    <div class="cart-summary-item">
                        <strong>Customer Name:</strong>
                        <span><?php echo htmlspecialchars($order['name']); ?></span>
                    </div>
                    <div class="cart-summary-item">
                        <strong>Customer Email:</strong>
                        <span><?php echo htmlspecialchars($order['email']); ?></span>
                    </div>
                    <div class="cart-summary-item">
                        <strong>Order Date & Time:</strong>
                        <span><?php echo date("d-M-Y H:i", strtotime($order['created_at'])); ?></span>
                    </div>
                    <div class="cart-summary-item">
                        <strong>Order Status:</strong>
                        <span style="background-color: <?php echo $order['status'] === 'Completed' ? '#d4edda' : '#fff3cd'; ?>; color: <?php echo $order['status'] === 'Completed' ? '#155724' : '#856404'; ?>; padding: 5px 10px; border-radius: 5px;">
                            <?php echo htmlspecialchars($order['status']); ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <h3>Ordered Items</h3>
            <table>
                <thead>
                    <tr>
                        <th>Food Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($item = mysqli_fetch_assoc($items_result)) {
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

            <!-- Total Amount -->
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

            <!-- Action Buttons -->
            <div style="text-align: center; margin-top: 30px;">
                <a href="admin_dashboard.php" class="btn btn-info">Back to Dashboard</a>
                <?php if ($order['status'] === 'Pending'): ?>
                    <a href="update_status.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-success" style="margin-left: 10px;">Mark as Completed</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Online Food Ordering System - All Rights Reserved</p>
    </footer>
</body>
</html>
