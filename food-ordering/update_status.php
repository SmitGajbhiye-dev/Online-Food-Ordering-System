<?php
// ================================================================
// UPDATE ORDER STATUS (update_status.php)
// ================================================================
// Allows admin to update the status of an order
// Changes status from Pending to Completed
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
// UPDATE ORDER STATUS
// ================================================================

// SQL query to update order status to Completed
$update_query = "UPDATE orders SET status = 'Completed' WHERE order_id = '$order_id'";

// Execute update query
if (mysqli_query($conn, $update_query)) {
    // Status updated successfully
    header("Location: admin_dashboard.php?success=Order status updated to Completed");
} else {
    // Update failed
    header("Location: admin_dashboard.php?error=Error updating order status");
}

// Close database connection
mysqli_close($conn);
?>
