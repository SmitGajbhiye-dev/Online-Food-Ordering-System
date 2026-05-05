-- ================================================================
-- ONLINE FOOD ORDERING SYSTEM - DATABASE SCHEMA
-- ================================================================
-- This SQL script creates the complete database structure for the
-- Food Ordering System with all required tables and sample data.
-- ================================================================

-- Create Database
CREATE DATABASE IF NOT EXISTS food_ordering;
USE food_ordering;

-- ================================================================
-- TABLE 1: USERS
-- ================================================================
-- Stores all user information including credentials
-- Primary Key: user_id (Auto-increment)
-- Purpose: User registration and login

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ================================================================
-- TABLE 2: FOOD
-- ================================================================
-- Stores all available food items in the menu
-- Primary Key: food_id (Auto-increment)
-- Purpose: Display menu items with prices

CREATE TABLE food (
    food_id INT AUTO_INCREMENT PRIMARY KEY,
    food_name VARCHAR(100) NOT NULL,
    price DECIMAL(8, 2) NOT NULL,
    description VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ================================================================
-- TABLE 3: ORDERS
-- ================================================================
-- Stores customer orders information
-- Primary Key: order_id (Auto-increment)
-- Foreign Key: user_id (References users table)
-- Status: Pending, Processing, Completed, Cancelled
-- Purpose: Track all customer orders

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- ================================================================
-- TABLE 4: ORDER_DETAILS
-- ================================================================
-- Stores line items for each order (items ordered with quantities)
-- Primary Key: order_detail_id (Auto-increment)
-- Foreign Keys: order_id (References orders), food_id (References food)
-- Purpose: Track quantities and items in each order

CREATE TABLE order_details (
    order_detail_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    food_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(8, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (food_id) REFERENCES food(food_id) ON DELETE CASCADE
);

-- ================================================================
-- SAMPLE DATA INSERTION
-- ================================================================

-- Insert Sample Users
INSERT INTO users (name, email, password) VALUES
('John Smith', 'john@email.com', 'password123'),
('Sarah Johnson', 'sarah@email.com', 'pass456'),
('Mike Williams', 'mike@email.com', 'secure789'),
('Emma Davis', 'emma@email.com', 'emmapass');

-- ================================================================
-- Insert Sample Food Items (5 items as required)
-- ================================================================
INSERT INTO food (food_name, price, description) VALUES
('Margherita Pizza', 350.00, 'Classic pizza with tomato and mozzarella'),
('Biryani', 280.00, 'Fragrant rice dish with spices and meat'),
('Butter Chicken', 320.00, 'Creamy curry with tender chicken pieces'),
('Samosa', 50.00, 'Crispy fried pastry with potato filling'),
('Mango Lassi', 80.00, 'Refreshing yogurt-based mango drink');

-- ================================================================
-- Insert Sample Orders (Optional - for testing admin panel)
-- ================================================================
INSERT INTO orders (user_id, total_amount, status) VALUES
(1, 430.00, 'Completed'),
(2, 360.00, 'Pending');

-- Insert Sample Order Details
INSERT INTO order_details (order_id, food_id, quantity, price) VALUES
(1, 1, 1, 350.00),
(1, 5, 1, 80.00),
(2, 2, 1, 280.00),
(2, 4, 2, 100.00);

-- ================================================================
-- VERIFICATION QUERIES (Run these to verify setup)
-- ================================================================
-- SELECT * FROM users;
-- SELECT * FROM food;
-- SELECT * FROM orders;
-- SELECT * FROM order_details;

-- ================================================================
-- END OF DATABASE SCHEMA
-- ================================================================
