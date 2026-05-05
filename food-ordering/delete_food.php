<?php
// ================================================================
// DELETE FOOD ITEM (delete_food.php)
// ================================================================
// Handles deletion of food items from database
// Checks referential integrity (no orders should reference this item)
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
// GET FOOD ID FROM URL
// ================================================================

if (!isset($_GET['food_id'])) {
    header("Location: view_food.php");
    exit();
}

$food_id = intval($_GET['food_id']);

// ================================================================
// DELETE FOOD ITEM
// ================================================================

// Check if this food item is referenced in any orders
$check_query = "SELECT COUNT(*) as count FROM order_details WHERE food_id = '$food_id'";
$check_result = mysqli_query($conn, $check_query);
$check_data = mysqli_fetch_assoc($check_result);

if ($check_data['count'] > 0) {
    // Item is referenced in orders, cannot delete
    $error = "Cannot delete this item as it has been ordered before.";
    header("Location: view_food.php?error=" . urlencode($error));
} else {
    // Delete the food item
    $delete_query = "DELETE FROM food WHERE food_id = '$food_id'";

    if (mysqli_query($conn, $delete_query)) {
        // Deletion successful
        header("Location: view_food.php?success=Food item deleted successfully");
    } else {
        // Deletion failed
        $error = "Error deleting food item: " . mysqli_error($conn);
        header("Location: view_food.php?error=" . urlencode($error));
    }
}

// Close database connection
mysqli_close($conn);
?>
