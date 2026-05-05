<?php
// ================================================================
// HOMEPAGE - FOOD MENU DISPLAY (index.php)
// ================================================================
// Displays all available food items from database
// Allows users to add items to cart (session-based)
// Shows login message for non-logged-in users
// ================================================================

// Start session to handle user data and cart
session_start();

// Include database connection file
require_once('db.php');

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// ================================================================
// HANDLE ADD TO CART SUBMISSION
// ================================================================

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect to login if not logged in
        header("Location: login.php?msg=Please login first");
        exit();
    }

    // Get food_id and quantity from form
    $food_id = intval($_POST['food_id']);
    $quantity = intval($_POST['quantity']) ?? 1;

    // Validate quantity
    if ($quantity <= 0) {
        $quantity = 1;
    }

    // ================================================================
    // ADD ITEM TO CART ARRAY
    // ================================================================
    // Check if item already in cart
    if (isset($_SESSION['cart'][$food_id])) {
        // Add to existing quantity
        $_SESSION['cart'][$food_id] += $quantity;
    } else {
        // Add new item to cart
        $_SESSION['cart'][$food_id] = $quantity;
    }

    // Redirect to cart page
    header("Location: cart.php?msg=Item added to cart");
    exit();
}

// ================================================================
// FETCH ALL FOOD ITEMS FROM DATABASE
// ================================================================

// SQL query to fetch all food items
$food_query = "SELECT * FROM food";

// Execute query
$food_result = mysqli_query($conn, $food_query);

// Check if query was successful
if (!$food_result) {
    die("Query Failed: " . mysqli_error($conn));
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Online Food Ordering System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <h1>🍕 Online Food Ordering System</h1>
        <p>Order Your Favorite Food Online</p>
    </header>

    <!-- Navigation -->
    <nav>
        <a href="index.php">Menu</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="cart.php">🛒 Cart</a>
            <a href="logout.php">Logout</a>
            <span style="color: white; margin-left: 20px;">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
            <a href="admin.php">Admin Panel</a>
        <?php endif; ?>
    </nav>

    <!-- Main Container -->
    <div class="container">
        <!-- Display Message if User Not Logged In -->
        <?php if (!isset($_SESSION['user_id'])): ?>
            <div class="alert alert-warning">
                ℹ️ Please <a href="login.php">login</a> to order food or <a href="register.php">register</a> for a new account.
            </div>
        <?php endif; ?>

        <div class="section">
            <h2>Available Food Menu</h2>

            <!-- Food Grid -->
            <div class="food-grid">
                <?php
                // ================================================================
                // DISPLAY ALL FOOD ITEMS
                // ================================================================

                if (mysqli_num_rows($food_result) > 0) {
                    // Loop through each food item
                    while ($food = mysqli_fetch_assoc($food_result)) {
                        $food_id = $food['food_id'];
                        $food_name = htmlspecialchars($food['food_name']);
                        $price = $food['price'];
                        $description = htmlspecialchars($food['description']);
                        ?>

                        <!-- Food Card -->
                        <div class="food-card">
                            <h3><?php echo $food_name; ?></h3>
                            <p><?php echo $description; ?></p>
                            <div class="price">₹<?php echo number_format($price, 2); ?></div>

                            <!-- Add to Cart Form -->
                            <form method="POST" action="">
                                <input type="hidden" name="food_id" value="<?php echo $food_id; ?>">

                                <!-- Quantity Input -->
                                <label for="quantity_<?php echo $food_id; ?>">Quantity:</label>
                                <input type="number" id="quantity_<?php echo $food_id; ?>" name="quantity" value="1" min="1" max="10" class="food-quantity">

                                <!-- Add to Cart Button -->
                                <button type="submit" name="add_to_cart" class="btn btn-success">
                                    <?php echo isset($_SESSION['user_id']) ? '🛒 Add to Cart' : 'Login to Order'; ?>
                                </button>
                            </form>
                        </div>

                        <?php
                    }
                } else {
                    // No food items in database
                    echo '<div class="empty-message">No food items available. Please check back later.</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Online Food Ordering System - All Rights Reserved</p>
    </footer>
</body>
</html>
