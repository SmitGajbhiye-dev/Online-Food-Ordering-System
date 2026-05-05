<?php
// ================================================================
// ADD FOOD ITEM PAGE (add_food.php)
// ================================================================
// Allows admin to add new food items to the menu
// Validates food name and price
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

// Initialize variables
$food_name = $description = $price = "";
$errors = $success = "";

// ================================================================
// HANDLE FORM SUBMISSION
// ================================================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $food_name = trim($_POST['food_name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = trim($_POST['price'] ?? '');

    // ================================================================
    // VALIDATION
    // ================================================================

    // Check if food name is provided
    if (empty($food_name)) {
        $errors = "Food name is required.";
    }
    // Check if price is provided
    elseif (empty($price)) {
        $errors = "Price is required.";
    }
    // Check if price is valid number
    elseif (!is_numeric($price) || $price <= 0) {
        $errors = "Price must be a positive number.";
    }
    else {
        // ================================================================
        // INSERT FOOD ITEM INTO DATABASE
        // ================================================================

        // SQL query to insert food item
        $insert_query = "INSERT INTO food (food_name, price, description) 
                       VALUES ('$food_name', '$price', '$description')";

        // Execute query
        if (mysqli_query($conn, $insert_query)) {
            // Food item added successfully
            $success = "Food item added successfully!";
            
            // Clear form fields
            $food_name = $description = $price = "";
        } else {
            // Database error
            $errors = "Error adding food item: " . mysqli_error($conn);
        }
    }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Food Item - Online Food Ordering System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <h1>🍕 Online Food Ordering System - Admin Panel</h1>
        <p>Add New Food Item</p>
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
            <h2>Add New Food Item</h2>

            <!-- Display Error Messages -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    ❌ <?php echo htmlspecialchars($errors); ?>
                </div>
            <?php endif; ?>

            <!-- Display Success Message -->
            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    ✓ <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <!-- Add Food Form -->
            <form method="POST" action="">
                <!-- Food Name Field -->
                <div class="form-group">
                    <label for="food_name">Food Item Name:</label>
                    <input type="text" id="food_name" name="food_name" value="<?php echo htmlspecialchars($food_name); ?>" required placeholder="e.g., Margherita Pizza">
                </div>

                <!-- Description Field -->
                <div class="form-group">
                    <label for="description">Description:</label>
                    <input type="text" id="description" name="description" value="<?php echo htmlspecialchars($description); ?>" placeholder="e.g., Fresh pizza with tomato and cheese">
                </div>

                <!-- Price Field -->
                <div class="form-group">
                    <label for="price">Price (₹):</label>
                    <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>" required placeholder="e.g., 350.00" step="0.01" min="0">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-success">✓ Add Food Item</button>
                <a href="view_food.php" class="btn btn-info" style="margin-left: 10px;">View All Items</a>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Online Food Ordering System - All Rights Reserved</p>
    </footer>
</body>
</html>
