<?php
// ================================================================
// USER LOGIN PAGE (login.php)
// ================================================================
// Authenticates user credentials using session
// Creates user session upon successful login
// ================================================================

// Start session for managing user login state
session_start();

// Include database connection file
require_once('db.php');

// Initialize variables
$email = $password = "";
$errors = "";

// ================================================================
// HANDLE FORM SUBMISSION (POST REQUEST)
// ================================================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // ================================================================
    // VALIDATE INPUT
    // ================================================================

    if (empty($email)) {
        $errors = "Email is required.";
    } elseif (empty($password)) {
        $errors = "Password is required.";
    } else {
        // ================================================================
        // QUERY DATABASE FOR USER
        // ================================================================

        // Hash the password to match stored hash
        $hashed_password = md5($password);

        // SQL query to fetch user with matching email and password
        $login_query = "SELECT * FROM users WHERE email = '$email' AND password = '$hashed_password'";

        // Execute query
        $result = mysqli_query($conn, $login_query);

        // Check if user exists
        if (mysqli_num_rows($result) == 1) {
            // User found - login successful
            
            // Fetch user data
            $user = mysqli_fetch_assoc($result);

            // ================================================================
            // CREATE USER SESSION
            // ================================================================
            // Session variables store user info for duration of session

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];

            // Redirect to menu page after successful login
            header("Location: index.php");
            exit();
        } else {
            // User not found - login failed
            $errors = "Invalid email or password.";
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
    <title>Login - Online Food Ordering System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <h1>🍕 Online Food Ordering System</h1>
        <p>User Login</p>
    </header>

    <!-- Navigation -->
    <nav>
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    </nav>

    <!-- Main Container -->
    <div class="container">
        <div class="section">
            <h2>User Login</h2>

            <!-- Display Error Messages -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    ❌ <?php echo htmlspecialchars($errors); ?>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="POST" action="">
                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Login</button>
                <span style="margin-left: 10px;">Don't have an account? <a href="register.php">Register here</a></span>
            </form>

            <!-- Admin Login Section -->
            <hr style="margin: 30px 0;">
            <h3>Admin Login</h3>
            <p>Use the following credentials to access admin panel:</p>
            <p><strong>Email:</strong> admin@foodordering.com</p>
            <p><strong>Password:</strong> admin123</p>

            <!-- Demo Credentials -->
            <hr style="margin: 30px 0;">
            <h3>Demo User Credentials</h3>
            <p>You can also use these demo credentials:</p>
            <p><strong>Email:</strong> john@email.com</p>
            <p><strong>Password:</strong> password123</p>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Online Food Ordering System - All Rights Reserved</p>
    </footer>
</body>
</html>
