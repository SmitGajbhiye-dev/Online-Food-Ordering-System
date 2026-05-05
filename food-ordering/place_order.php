<?php
// ================================================================
// PLACE ORDER PAGE (place_order.php)
// ================================================================
// Processes cart items and creates order in database
// Saves order details (line items) to order_details table
// Clears cart after successful order placement
// ================================================================

// Start session to access user data and cart
session_start();

// Include database connection file
require_once('db.php');

// ================================================================
// REDIRECT TO LOGIN IF NOT LOGGED IN
// ================================================================

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?msg=Please login to place order");
    exit();
}

// ================================================================
// REDIRECT TO MENU IF CART IS EMPTY
// ================================================================

if (empty($_SESSION['cart'])) {
    header("Location: index.php?msg=Your cart is empty");
    exit();
}

// ================================================================
// HANDLE ORDER PLACEMENT (POST REQUEST)
// ================================================================

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_order'])) {
    // Get user data
    $user_id = $_SESSION['user_id'];

    // ================================================================
    // CALCULATE TOTAL BILL
    // ================================================================

    $total_amount = 0;

    // Get food_ids from cart
    $food_ids = implode(',', array_keys($_SESSION['cart']));

    // Query to get food prices
    $food_query = "SELECT food_id, price FROM food WHERE food_id IN ($food_ids)";
    $food_result = mysqli_query($conn, $food_query);

    // Calculate total
    $food_prices = array();
    while ($food = mysqli_fetch_assoc($food_result)) {
        $food_id = $food['food_id'];
        $price = $food['price'];
        $quantity = $_SESSION['cart'][$food_id];

        // Add to total
        $total_amount += ($price * $quantity);

        // Store prices for later use
        $food_prices[$food_id] = $price;
    }

    // ================================================================
    // INSERT ORDER INTO ORDERS TABLE
    // ================================================================

    // SQL query to insert new order
    $order_query = "INSERT INTO orders (user_id, total_amount, status) 
                   VALUES ('$user_id', '$total_amount', 'Pending')";

    // Execute insert query
    if (mysqli_query($conn, $order_query)) {
        // Get the ID of newly inserted order
        $order_id = mysqli_insert_id($conn);

        // ================================================================
        // INSERT ORDER DETAILS (LINE ITEMS)
        // ================================================================

        // For each item in cart, insert into order_details table
        foreach ($_SESSION['cart'] as $food_id => $quantity) {
            // Get price from stored array
            $price = $food_prices[$food_id];

            // SQL query to insert order detail
            $detail_query = "INSERT INTO order_details (order_id, food_id, quantity, price) 
                           VALUES ('$order_id', '$food_id', '$quantity', '$price')";

            // Execute query
            if (!mysqli_query($conn, $detail_query)) {
                // Error inserting order detail
                die("Error: " . mysqli_error($conn));
            }
        }

        // ================================================================
        // CLEAR CART AND REDIRECT
        // ================================================================

        // Clear cart from session after successful order
        unset($_SESSION['cart']);

        // Close database connection
        mysqli_close($conn);

        // Redirect to order summary page
        header("Location: order_summary.php?order_id=$order_id");
        exit();

    } else {
        // Error inserting order
        $error = "Error placing order: " . mysqli_error($conn);
    }
}

// ================================================================
// FETCH CART ITEMS FOR DISPLAY
// ================================================================

$total_bill = 0;
$cart_items = array();

if (!empty($_SESSION['cart'])) {
    $food_ids = implode(',', array_keys($_SESSION['cart']));
    $cart_query = "SELECT * FROM food WHERE food_id IN ($food_ids)";
    $cart_result = mysqli_query($conn, $cart_query);

    while ($item = mysqli_fetch_assoc($cart_result)) {
        $food_id = $item['food_id'];
        $quantity = $_SESSION['cart'][$food_id];
        $item_total = $item['price'] * $quantity;
        $total_bill += $item_total;

        $cart_items[] = array(
            'food_id' => $food_id,
            'food_name' => $item['food_name'],
            'price' => $item['price'],
            'quantity' => $quantity,
            'item_total' => $item_total
        );
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
    <title>Checkout - Online Food Ordering System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <h1>🍕 Online Food Ordering System</h1>
        <p>Complete Your Order</p>
    </header>

    <!-- Navigation -->
    <nav>
        <a href="index.php">Menu</a>
        <a href="cart.php">🛒 Cart</a>
        <a href="logout.php">Logout</a>
        <span style="color: white; margin-left: 20px;">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
    </nav>

    <!-- Main Container -->
    <div class="container">
        <div class="section">
            <h2>Order Confirmation</h2>

            <!-- Display Error Message -->
            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    ❌ <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <!-- Order Summary -->
            <div style="background-color: #f9f9f9; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h3>Order Summary</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($cart_items as $item) {
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['food_name']); ?></td>
                                <td>₹<?php echo number_format($item['price'], 2); ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td>₹<?php echo number_format($item['item_total'], 2); ?></td>
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
                        <span>₹<?php echo number_format($total_bill, 2); ?></span>
                    </div>
                    <div class="cart-summary-item">
                        <strong>Delivery Charge:</strong>
                        <span>₹0.00</span>
                    </div>
                    <div class="cart-summary-item">
                        <strong>Tax (0%):</strong>
                        <span>₹0.00</span>
                    </div>
                    <div class="cart-total">
                        <strong>Total Amount:</strong>
                        <strong>₹<?php echo number_format($total_bill, 2); ?></strong>
                    </div>
                </div>
            </div>

            <!-- Delivery Address -->
            <div style="background-color: #f0f0f0; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h3>Delivery Details</h3>
                <p><strong>Deliver To:</strong> <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
                <p><strong>Estimated Delivery Time:</strong> 30-45 minutes</p>
            </div>

            <!-- Place Order Form -->
            <form method="POST" action="" style="text-align: center;">
                <button type="submit" name="place_order" class="btn btn-success" style="padding: 12px 30px; font-size: 1.1em;">
                    ✓ Confirm Order (₹<?php echo number_format($total_bill, 2); ?>)
                </button>
                <a href="cart.php" class="btn btn-info" style="margin-left: 10px;">Edit Cart</a>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Online Food Ordering System - All Rights Reserved</p>
    </footer>
</body>
</html>
