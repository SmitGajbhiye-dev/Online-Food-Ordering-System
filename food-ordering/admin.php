<?php
// ================================================================
// ADMIN LOGIN PAGE (admin.php)
// ================================================================
// Simple admin authentication using hardcoded credentials
// Allows admin to access management panel
// ================================================================

// Start session
session_start();

// Include database connection file
require_once('db.php');

// Initialize variables
$email = $password = "";
$errors = "";

// ================================================================
// HANDLE ADMIN LOGIN FORM
// ================================================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // ================================================================
    // HARDCODED ADMIN CREDENTIALS
    // ================================================================

    $admin_email = "admin@foodordering.com";
    $admin_password = "admin123";

    // Validate input
    if (empty($email)) {
        $errors = "Email is required.";
    } elseif (empty($password)) {
        $errors = "Password is required.";
    }
    // Check admin credentials
    elseif ($email === $admin_email && $password === $admin_password) {
        // Admin credentials correct - create session
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $admin_email;

        // Redirect to admin dashboard
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Invalid credentials
        $errors = "Invalid admin email or password.";
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
    <title>Admin Login - Online Food Ordering System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <h1>🍕 Online Food Ordering System</h1>
        <p>Admin Panel Login</p>
    </header>

    <!-- Navigation -->
    <nav>
        <a href="index.php">Home</a>
        <a href="login.php">User Login</a>
        <a href="register.php">Register</a>
    </nav>

    <!-- Main Container -->
    <div class="container">
        <div class="section">
            <h2>Admin Login</h2>

            <!-- Display Error Messages -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    ❌ <?php echo htmlspecialchars($errors); ?>
                </div>
            <?php endif; ?>

            <!-- Admin Login Form -->
            <form method="POST" action="">
                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">Admin Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password">Admin Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Login to Admin Panel</button>
            </form>

            <!-- Demo Credentials -->
            <hr style="margin: 30px 0;">
            <div class="alert alert-info">
                <h3>Admin Demo Credentials:</h3>
                <p><strong>Email:</strong> admin@foodordering.com</p>
                <p><strong>Password:</strong> admin123</p>
                <p style="margin-top: 10px; font-size: 0.9em;">⚠️ These are demo credentials for testing. Change them in production.</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Online Food Ordering System - All Rights Reserved</p>
    </footer>
</body>
</html>
