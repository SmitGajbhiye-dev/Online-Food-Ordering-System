<?php
// ================================================================
// ADMIN DASHBOARD (admin_dashboard.php)
// ================================================================
// Shows all orders, allows admin to update status
// Displays sales statistics and available food items
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
// FETCH STATISTICS
// ================================================================

// Total orders query
$total_orders_query = "SELECT COUNT(*) as total FROM orders";
$total_orders_result = mysqli_query($conn, $total_orders_query);
$total_orders = mysqli_fetch_assoc($total_orders_result)['total'];

// Total revenue query
$total_revenue_query = "SELECT SUM(total_amount) as revenue FROM orders";
$total_revenue_result = mysqli_query($conn, $total_revenue_query);
$total_revenue = mysqli_fetch_assoc($total_revenue_result)['revenue'] ?? 0;

// Pending orders query
$pending_orders_query = "SELECT COUNT(*) as pending FROM orders WHERE status = 'Pending'";
$pending_orders_result = mysqli_query($conn, $pending_orders_query);
$pending_orders = mysqli_fetch_assoc($pending_orders_result)['pending'];

// Total food items query
$food_count_query = "SELECT COUNT(*) as total_food FROM food";
$food_count_result = mysqli_query($conn, $food_count_query);
$food_count = mysqli_fetch_assoc($food_count_result)['total_food'];

// ================================================================
// FETCH ALL ORDERS
// ================================================================

// Query to get all orders with user names
$orders_query = "SELECT o.*, u.name FROM orders o 
                JOIN users u ON o.user_id = u.user_id 
                ORDER BY o.created_at DESC";

$orders_result = mysqli_query($conn, $orders_query);

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Online Food Ordering System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <h1>🍕 Online Food Ordering System - Admin Panel</h1>
        <p>Dashboard</p>
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
            <h2>Admin Dashboard</h2>

            <!-- Statistics Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
                <!-- Total Orders Card -->
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 8px; text-align: center;">
                    <h3 style="font-size: 2em; margin: 0;">📦 <?php echo $total_orders; ?></h3>
                    <p>Total Orders</p>
                </div>

                <!-- Pending Orders Card -->
                <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 20px; border-radius: 8px; text-align: center;">
                    <h3 style="font-size: 2em; margin: 0;">⏳ <?php echo $pending_orders; ?></h3>
                    <p>Pending Orders</p>
                </div>

                <!-- Total Revenue Card -->
                <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 20px; border-radius: 8px; text-align: center;">
                    <h3 style="font-size: 2em; margin: 0;">💰 ₹<?php echo number_format($total_revenue, 2); ?></h3>
                    <p>Total Revenue</p>
                </div>

                <!-- Food Items Card -->
                <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; padding: 20px; border-radius: 8px; text-align: center;">
                    <h3 style="font-size: 2em; margin: 0;">🍽️ <?php echo $food_count; ?></h3>
                    <p>Food Items</p>
                </div>
            </div>

            <!-- All Orders Table -->
            <h3>All Orders</h3>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($orders_result) > 0) {
                        while ($order = mysqli_fetch_assoc($orders_result)) {
                            $order_id = $order['order_id'];
                            $customer_name = htmlspecialchars($order['name']);
                            $total_amount = $order['total_amount'];
                            $status = htmlspecialchars($order['status']);
                            $order_date = date("d-M-Y H:i", strtotime($order['created_at']));
                            
                            // Color code status
                            if ($status === 'Pending') {
                                $status_color = '#fff3cd';
                                $status_text_color = '#856404';
                            } elseif ($status === 'Completed') {
                                $status_color = '#d4edda';
                                $status_text_color = '#155724';
                            } else {
                                $status_color = '#f8d7da';
                                $status_text_color = '#721c24';
                            }
                            ?>
                            <tr>
                                <td>#<?php echo str_pad($order_id, 5, '0', STR_PAD_LEFT); ?></td>
                                <td><?php echo $customer_name; ?></td>
                                <td>₹<?php echo number_format($total_amount, 2); ?></td>
                                <td>
                                    <span style="background-color: <?php echo $status_color; ?>; color: <?php echo $status_text_color; ?>; padding: 5px 10px; border-radius: 5px; font-weight: bold;">
                                        <?php echo $status; ?>
                                    </span>
                                </td>
                                <td><?php echo $order_date; ?></td>
                                <td>
                                    <a href="view_order_details.php?order_id=<?php echo $order_id; ?>" class="btn btn-info" style="padding: 5px 10px; text-decoration: none;">View</a>
                                    <?php if ($status === 'Pending'): ?>
                                        <a href="update_status.php?order_id=<?php echo $order_id; ?>" class="btn btn-success" style="padding: 5px 10px; text-decoration: none;">Complete</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo '<tr><td colspan="6" class="text-center">No orders found</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Online Food Ordering System - All Rights Reserved</p>
    </footer>
</body>
</html>
