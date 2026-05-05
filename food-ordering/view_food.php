<?php
// ================================================================
// VIEW AND MANAGE FOOD ITEMS (view_food.php)
// ================================================================
// Displays all food items in table format
// Allows admin to delete food items
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
// HANDLE DELETE REQUEST
// ================================================================

$delete_message = "";

if (isset($_GET['delete_id'])) {
    $food_id = intval($_GET['delete_id']);

    // ================================================================
    // CHECK IF FOOD ITEM IS IN ANY ORDER
    // ================================================================

    // Query to check if this food item is referenced in order_details
    $check_query = "SELECT COUNT(*) as count FROM order_details WHERE food_id = '$food_id'";
    $check_result = mysqli_query($conn, $check_query);
    $check_data = mysqli_fetch_assoc($check_result);

    // If item is in an order, cannot delete (referential integrity)
    if ($check_data['count'] > 0) {
        $delete_message = "Cannot delete this item as it has been ordered before.";
    } else {
        // ================================================================
        // DELETE FOOD ITEM
        // ================================================================

        // SQL query to delete food item
        $delete_query = "DELETE FROM food WHERE food_id = '$food_id'";

        // Execute delete query
        if (mysqli_query($conn, $delete_query)) {
            $delete_message = "✓ Food item deleted successfully!";
        } else {
            $delete_message = "Error deleting food item: " . mysqli_error($conn);
        }
    }
}

// ================================================================
// FETCH ALL FOOD ITEMS
// ================================================================

// SQL query to get all food items
$food_query = "SELECT * FROM food ORDER BY food_id DESC";

// Execute query
$food_result = mysqli_query($conn, $food_query);

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Food Items - Online Food Ordering System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <h1>🍕 Online Food Ordering System - Admin Panel</h1>
        <p>Manage Food Items</p>
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
            <h2>Manage Food Items</h2>

            <!-- Display Delete Message -->
            <?php if (!empty($delete_message)): ?>
                <div class="alert alert-<?php echo strpos($delete_message, '✓') !== false ? 'success' : 'danger'; ?>">
                    <?php echo htmlspecialchars($delete_message); ?>
                </div>
            <?php endif; ?>

            <!-- Add Food Button -->
            <div style="margin-bottom: 20px;">
                <a href="add_food.php" class="btn btn-success">+ Add New Food Item</a>
            </div>

            <!-- Food Items Table -->
            <table>
                <thead>
                    <tr>
                        <th>Food ID</th>
                        <th>Food Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($food_result) > 0) {
                        while ($food = mysqli_fetch_assoc($food_result)) {
                            $food_id = $food['food_id'];
                            $food_name = htmlspecialchars($food['food_name']);
                            $description = htmlspecialchars($food['description'] ?? 'N/A');
                            $price = $food['price'];
                            $created_at = date("d-M-Y H:i", strtotime($food['created_at']));
                            ?>
                            <tr>
                                <td>#<?php echo $food_id; ?></td>
                                <td><?php echo $food_name; ?></td>
                                <td><?php echo $description; ?></td>
                                <td>₹<?php echo number_format($price, 2); ?></td>
                                <td><?php echo $created_at; ?></td>
                                <td>
                                    <a href="delete_food.php?food_id=<?php echo $food_id; ?>" class="btn btn-danger" style="padding: 5px 10px; text-decoration: none;" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo '<tr><td colspan="6" class="text-center">No food items found</td></tr>';
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
