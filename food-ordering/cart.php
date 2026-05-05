<?php
// ================================================================
// SHOPPING CART PAGE (cart.php)
// ================================================================
// Displays items added to cart by user
// Allows editing quantity and removing items
// Shows total bill and proceed to checkout button
// ================================================================

// Start session to access cart data
session_start();

// Include database connection file
require_once('db.php');

// ================================================================
// REDIRECT TO LOGIN IF NOT LOGGED IN
// ================================================================

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?msg=Please login to view your cart");
    exit();
}

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// ================================================================
// HANDLE REMOVE FROM CART
// ================================================================

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_item'])) {
    // Get food_id to remove
    $food_id = intval($_POST['food_id']);

    // Remove item from cart array
    unset($_SESSION['cart'][$food_id]);

    // Set success message
    $message = "Item removed from cart";
}

// ================================================================
// HANDLE UPDATE QUANTITY
// ================================================================

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_quantity'])) {
    // Get food_id and new quantity
    $food_id = intval($_POST['food_id']);
    $quantity = intval($_POST['quantity']) ?? 1;

    // Validate quantity
    if ($quantity > 0) {
        $_SESSION['cart'][$food_id] = $quantity;
        $message = "Quantity updated";
    } else {
        // Remove item if quantity is 0
        unset($_SESSION['cart'][$food_id]);
        $message = "Item removed from cart";
    }
}

// ================================================================
// CALCULATE TOTAL BILL
// ================================================================

$total_bill = 0;
$cart_items = array();

// If cart has items, fetch details from database
if (!empty($_SESSION['cart'])) {
    // Build comma-separated list of food_ids
    $food_ids = implode(',', array_keys($_SESSION['cart']));

    // SQL query to fetch food details for items in cart
    $cart_query = "SELECT * FROM food WHERE food_id IN ($food_ids)";

    // Execute query
    $cart_result = mysqli_query($conn, $cart_query);

    // Fetch each item and calculate total
    while ($item = mysqli_fetch_assoc($cart_result)) {
        $food_id = $item['food_id'];
        $quantity = $_SESSION['cart'][$food_id];

        // Calculate item total
        $item_total = $item['price'] * $quantity;

        // Add to total bill
        $total_bill += $item_total;

        // Store item details
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
    <title>Cart - Online Food Ordering System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <h1>🍕 Online Food Ordering System</h1>
        <p>Your Shopping Cart</p>
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
            <h2>Shopping Cart</h2>

            <!-- Display Success Message -->
            <?php if (isset($message)): ?>
                <div class="alert alert-success">
                    ✓ <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <!-- ================================================================
                 CART ITEMS TABLE (if cart is not empty)
                 ================================================================ -->

            <?php if (!empty($cart_items)): ?>

                <table>
                    <thead>
                        <tr>
                            <th>Food Item</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Display each item in cart
                        foreach ($cart_items as $item) {
                            $food_id = $item['food_id'];
                            $food_name = htmlspecialchars($item['food_name']);
                            $price = $item['price'];
                            $quantity = $item['quantity'];
                            $item_total = $item['item_total'];
                            ?>
                            <tr>
                                <td><?php echo $food_name; ?></td>
                                <td>₹<?php echo number_format($price, 2); ?></td>
                                <td>
                                    <!-- Update Quantity Form -->
                                    <form method="POST" action="" style="display: inline;">
                                        <input type="hidden" name="food_id" value="<?php echo $food_id; ?>">
                                        <input type="number" name="quantity" value="<?php echo $quantity; ?>" min="1" max="10" style="width: 50px;">
                                        <button type="submit" name="update_quantity" class="btn btn-warning" style="padding: 5px 10px;">Update</button>
                                    </form>
                                </td>
                                <td>₹<?php echo number_format($item_total, 2); ?></td>
                                <td>
                                    <!-- Remove Item Form -->
                                    <form method="POST" action="" style="display: inline;">
                                        <input type="hidden" name="food_id" value="<?php echo $food_id; ?>">
                                        <button type="submit" name="remove_item" class="btn btn-danger" style="padding: 5px 10px;">Remove</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>

                <!-- ================================================================
                     CART SUMMARY
                     ================================================================ -->

                <div class="cart-summary">
                    <div class="cart-summary-item">
                        <strong>Subtotal:</strong>
                        <span>₹<?php echo number_format($total_bill, 2); ?></span>
                    </div>
                    <div class="cart-summary-item">
                        <strong>Delivery Charge:</strong>
                        <span>₹0.00</span>
                    </div>
                    <div class="cart-total">
                        <strong>Total Bill:</strong>
                        <strong>₹<?php echo number_format($total_bill, 2); ?></strong>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="text-align: center; margin-top: 20px;">
                    <a href="index.php" class="btn btn-info">Continue Shopping</a>
                    <a href="place_order.php" class="btn btn-success" style="margin-left: 10px;">Proceed to Checkout</a>
                </div>

            <?php else: ?>

                <!-- ================================================================
                     EMPTY CART MESSAGE
                     ================================================================ -->

                <div class="empty-message">
                    <h3>Your cart is empty</h3>
                    <p>Add items from the menu to continue shopping.</p>
                    <a href="index.php" class="btn btn-primary" style="margin-top: 10px;">Go to Menu</a>
                </div>

            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Online Food Ordering System - All Rights Reserved</p>
    </footer>
</body>
</html>
