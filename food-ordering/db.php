<?php
// ================================================================
// DATABASE CONNECTION FILE (db.php)
// ================================================================
// This file handles all database connection logic for MySQL
// Uses procedural MySQLi for beginner-friendly approach
// ================================================================

// Database Configuration Variables
$db_host = "localhost";      // MySQL Server Host
$db_user = "root";           // MySQL Username (Default in XAMPP)
$db_pass = "";               // MySQL Password (Default empty in XAMPP)
$db_name = "food_ordering";  // Database Name

// ================================================================
// CREATE DATABASE CONNECTION
// ================================================================
// mysqli_connect() creates connection to MySQL server
// Parameters: host, user, password, database_name

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// ================================================================
// ERROR HANDLING
// ================================================================
// Check if connection was successful
// If not, display error message and stop execution

if (!$conn) {
    // Connection failed - display error
    die("Connection Failed: " . mysqli_connect_error());
    // mysqli_connect_error() returns the error description
}

// ================================================================
// SET CHARACTER SET
// ================================================================
// Ensure all data is handled in UTF-8 format
// This supports special characters and multiple languages

mysqli_set_charset($conn, "utf8");

// ================================================================
// NOTE FOR STUDENTS:
// ================================================================
// This connection is used in all other PHP files
// Always include this file using: require_once('db.php');
// This ensures database access throughout the application
// ================================================================
?>
