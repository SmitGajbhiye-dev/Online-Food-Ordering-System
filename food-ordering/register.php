<?php
// ================================================================
// USER REGISTRATION PAGE (register.php)
// ================================================================
// Allows new users to create an account
// Validates email uniqueness and password
// ================================================================

// Start session to manage user data
session_start();

// Include database connection file
require_once('db.php');

// Initialize variables
$name = $email = $password = $cpassword = "";
$errors = $success = "";

// ================================================================
// HANDLE FORM SUBMISSION (POST REQUEST)
// ================================================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and get form data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $cpassword = $_POST['cpassword'] ?? '';

    // ================================================================
    // VALIDATION CHECKS
    // ================================================================

    // Check if name is provided
    if (empty($name)) {
        $errors = "Name is required.";
    }
    // Check if email is provided
    elseif (empty($email)) {
        $errors = "Email is required.";
    }
    // Check if email format is valid
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors = "invalid email format.";
    }
    // Check if password is provided
    elseif (empty($password)) {
        $errors = "Password is required.";
    }
    // Check if passwords match
    elseif ($password != $cpassword) {
        $errors = "Passwords do not match.";
    }
    // Check password length (minimum 6 characters)
    elseif (strlen($password) < 6) {
        $errors = "Password must be at least 6 characters long.";
    }
    // If all validations pass, proceed with registration
    else {
        // ================================================================
        // CHECK IF EMAIL ALREADY EXISTS
        // ================================================================

        // SQL query to check if email exists in database
        $check_email_query = "SELECT user_id FROM users WHERE email = '$email'";
        
        // Execute query
        $result = mysqli_query($conn, $check_email_query);

        // If email already exists
        if (mysqli_num_rows($result) > 0) {
            $errors = "Email already registered. Please use another email.";
        } else {
            // ================================================================
            // HASH PASSWORD AND INSERT USER INTO DATABASE
            // ================================================================

            // Hash the password using MD5 for simplicity (Not recommended for production)
            // Note: In real applications, use password_hash() with bcrypt
            $hashed_password = md5($password);

            // SQL query to insert new user into database
            $insert_query = "INSERT INTO users (name, email, password) 
                           VALUES ('$name', '$email', '$hashed_password')";

            // Execute insert query
            if (mysqli_query($conn, $insert_query)) {
                // Registration successful
                $success = "Registration successful! You can now login.";
                
                // Clear form fields
                $name = $email = $password = $cpassword = "";
            } else {
                // Database error
                $errors = "Error during registration: " . mysqli_error($conn);
            }
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
    <title>Register - Online Food Ordering System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <h1>🍕 Online Food Ordering System</h1>
        <p>Create Your Account</p>
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
            <h2>User Registration</h2>

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

            <!-- Registration Form -->
            <form method="POST" action="">
                <!-- Name Field -->
                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                </div>

                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password">Password (min 6 characters):</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <!-- Confirm Password Field -->
                <div class="form-group">
                    <label for="cpassword">Confirm Password:</label>
                    <input type="password" id="cpassword" name="cpassword" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Register</button>
                <span style="margin-left: 10px;">Already have an account? <a href="login.php">Login here</a></span>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Online Food Ordering System - All Rights Reserved</p>
    </footer>
</body>
</html>
