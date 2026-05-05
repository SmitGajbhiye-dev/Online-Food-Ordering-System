# VIVA QUESTIONS & ANSWERS

## ONLINE FOOD ORDERING SYSTEM

### Prepared for: Second-Year Engineering Students
### Total Questions: 15 Important Questions

---

## 1. PROJECT OVERVIEW

### Q1: What is the main purpose of the Online Food Ordering System?
**Answer:**
The Online Food Ordering System is a web-based application that allows customers to:
- Browse available food items online
- Place orders 24/7 without calling the restaurant
- View order status and history
- Track their orders in real-time

For administrators, it provides tools to:
- Manage food menu items
- View and process customer orders
- Update order status
- Analyze sales data

### Q2: What are the key features of this system?
**Answer:**
**User Features:**
1. User Registration & Login (with session management)
2. Browse Food Menu (view all items with prices)
3. Add Items to Cart (with quantity selection)
4. Shopping Cart Management (view, edit, remove items)
5. Place Orders (checkout process)
6. Order Summary (order confirmation with ID)
7. Logout (session destruction)

**Admin Features:**
1. Admin Login (hardcoded credentials)
2. View Dashboard (statistics and metrics)
3. View All Orders (with customer details)
4. Update Order Status (mark as completed)
5. Add Food Items (to expand menu)
6. Delete Food Items (if not in any order)
7. View Order Details (items, quantities, total)

---

## 2. DATABASE DESIGN

### Q3: Describe the database schema for this project. What tables are used and why?
**Answer:**
The database has 4 main tables, structured using relational model and normalized to 3NF:

**1. USERS Table:**
```
Fields: user_id (PK), name, email (UNIQUE), password, created_at
Purpose: Store user account information for registration and authentication
```

**2. FOOD Table:**
```
Fields: food_id (PK), food_name, price, description, created_at
Purpose: Store all menu items available for ordering
```

**3. ORDERS Table:**
```
Fields: order_id (PK), user_id (FK), total_amount, status, created_at
Purpose: Track all orders placed by customers
Relationships: Links to USERS (one customer can place many orders)
```

**4. ORDER_DETAILS Table:**
```
Fields: order_detail_id (PK), order_id (FK), food_id (FK), quantity, price
Purpose: Store line items for each order (which items were ordered)
Relationships: 
  - Links to ORDERS (each order has many items)
  - Links to FOOD (each item can be ordered many times)
```

### Q4: What do Foreign Keys do in this project?
**Answer:**
Foreign Keys maintain **referential integrity** between tables:

**Example 1: ORDERS.user_id references USERS.user_id**
- Ensures every order belongs to a valid user
- If a user is deleted, their orders are automatically deleted (CASCADE)
- Prevents creating an order for a non-existent user

**Example 2: ORDER_DETAILS.order_id references ORDERS.order_id**
- Ensures order items belong to a valid order
- If an order is deleted, all its items are deleted
- Maintains data consistency

**Example 3: ORDER_DETAILS.food_id references FOOD.food_id**
- Ensures order items reference valid food items
- Prevents ordering non-existent food items

### Q5: Explain the concept of Database Normalization. Is this project normalized to 3NF?
**Answer:**
Database Normalization is a process of organizing data to reduce redundancy and improve data integrity.

**Three Normal Forms:**

**1NF (First Normal Form):**
- Remove repeating groups
- Every attribute has only one value
- Status: ✓ Already in 1NF
- All fields are atomic (single values)

**2NF (Second Normal Form):**
- Must be in 1NF
- Remove partial dependencies
- Every non-key attribute must depend on the ENTIRE primary key
- Status: ✓ Already in 2NF
- In ORDERS table: total_amount depends fully on order_id
- In ORDER_DETAILS: quantity depends on both order_id AND food_id

**3NF (Third Normal Form):**
- Must be in 2NF
- Remove transitive dependencies
- No non-key attribute can depend on another non-key attribute
- Status: ✓ Already in 3NF
- Example: We don't store user_name in ORDERS table
  - That would create: order_id → user_id → user_name (transitive)
  - Solution: Keep user data separate in USERS table

### Q6: What does "Referential Integrity" mean and how is it implemented?
**Answer:**
Referential Integrity ensures data consistency by maintaining valid relationships between tables.

**Implementation:**
- Use Foreign Key constraints
- Define what happens when data is deleted or updated

**SQL Example:**
```sql
ALTER TABLE orders 
ADD FOREIGN KEY (user_id) REFERENCES users(user_id) 
ON DELETE CASCADE;
```

**What CASCADE means:**
- If a user is deleted from USERS table
- All their orders in ORDERS table are automatically deleted
- Maintains data consistency

**Benefits:**
- Prevents orphaned records
- Ensures data accuracy
- Maintains business logic

---

## 3. WEB APPLICATION CONCEPTS

### Q7: Explain How Sessions Work in PHP. Why is Session Management Important?
**Answer:**
**What is a Session?**
- A session is a way to store user information across multiple pages
- Each user gets a unique session ID (stored in cookies)
- Session data is stored on the server (in memory or files)

**Session Flow:**
```
1. User logs in
2. Server creates session variables:
   $_SESSION['user_id'] = 1
   $_SESSION['user_name'] = 'John'
   $_SESSION['user_email'] = 'john@email.com'
3. User browses website
4. Each page checks: if (!isset($_SESSION['user_id'])) redirect to login;
5. User logs out
6. session_destroy() clears all session variables
```

**Why Important:**
- **Authentication**: Track who is logged in
- **Cart Management**: Store cart items temporarily
- **Security**: Keep sensitive data server-side
- **Persistence**: User stays logged in while browsing

**In Our Project:**
- After login: `$_SESSION['user_id']` is set
- User can add items to cart (in SESSION['cart'])
- Logout destroys session, clearing everything

### Q8: What is the difference between session-based cart and database-based cart?
**Answer:**
**Session-based Cart (Our Project):**
```php
$_SESSION['cart'] = array(
    1 => 2,  // Food ID 1, Quantity 2
    3 => 1   // Food ID 3, Quantity 1
);
```
- Stored in server memory
- Temporary (cleared when browser closes or logout)
- Fast access
- User data not saved if browser crashes
- Good for: Simple, quick projects

**Database-based Cart:**
```sql
CREATE TABLE cart (
    cart_id INT,
    user_id INT,
    food_id INT,
    quantity INT
);
```
- Stored permanently in database
- Persists even after logout
- User can return to incomplete cart
- Slower but more reliable
- Good for: E-commerce sites, production systems

**Our Choice (Session-based):** Perfect for learning, simple to implement

### Q9: Explain the concept of "Prepared Statements" and why they prevent SQL Injection.
**Answer:**
**What is SQL Injection?**
A security vulnerability where attackers insert malicious SQL code through input fields.

**Example Attack:**
```php
// VULNERABLE CODE:
$email = "john@email.com' OR '1'='1";
$query = "SELECT * FROM users WHERE email = '$email'";
// Results in: SELECT * FROM users WHERE email = 'john@email.com' OR '1'='1';
// This returns ALL users (1=1 is always true)
```

**Prepared Statements Prevention:**
```php
// SAFER (but not used in this beginner project):
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
```

**How it works:**
- SQL structure is defined first
- User input is added separately
- Database knows what's code and what's data
- Malicious code is treated as literal text, not executed

**In Our Project:**
- We use basic validation and escaping
- For production: use `mysqli_real_escape_string()` or prepared statements

---

## 4. TECHNOLOGY STACK

### Q10: Why did we choose PHP (procedural) instead of Python or Node.js?
**Answer:**
**Reasons for PHP:**
1. **Ease of Learning**
   - Simple syntax, beginner-friendly
   - Easy to understand for second-year students
   - Procedural approach (not OOP) matches curriculum

2. **Web Development**
   - Built for web (works directly with Apache)
   - No additional framework overhead
   - Direct database integration

3. **Server-side Processing**
   - Executes on server, browser-safe
   - Session management easy
   - Form processing straightforward

4. **Compatibility**
   - Runs on XAMPP (included)
   - Works with MySQL directly
   - No additional installations needed

5. **Industry Standard**
   - Powers 77% of websites globally
   - Good for learning
   - Widely used in small/medium projects

**Why not other languages:**
- **Python**: Needs Django/Flask framework (complex for beginners)
- **Node.js**: Requires npm modules and JavaScript knowledge
- **Java**: Too complex for beginner project
- **C#**: Requires ASP.NET framework

### Q11: Why MySQL and not SQL Server or PostgreSQL?
**Answer:**
**Reasons for MySQL:**
1. **Open Source & Free**
   - No licensing costs
   - Community support
   - Easy for students

2. **Included in XAMPP**
   - No separate installation
   - Pre-configured
   - Ready to use

3. **Beginner-Friendly**
   - Simple SQL syntax
   - Straightforward queries
   - Good documentation

4. **Relational Database**
   - Supports foreign keys
   - Normalization (1NF, 2NF, 3NF)
   - Maintains referential integrity

5. **Integration with PHP**
   - Direct MySQLi connection
   - Quick queries
   - Easy debugging with phpMyAdmin

**Comparison:**
- **SQL Server**: Enterprise (expensive, overkill)
- **PostgreSQL**: More complex features (not needed for learning)
- **MySQL**: Perfect middle ground for students

### Q12: What is XAMPP and why is it ideal for beginners?
**Answer:**
**XAMPP = Apache + MySQL + PHP + Pearl**

**Components:**
1. **Apache**: Web server (serves HTML, PHP files)
2. **MySQL**: Database server
3. **PHP**: Programming language
4. **Pearl**: Programming language (rarely used)
5. **phpMyAdmin**: GUI for managing databases

**Why Ideal for Beginners:**
1. **All-in-One Package**
   - Don't need to install and configure each separately
   - Everything works together
   - Saves time

2. **Free & Open Source**
   - No licensing fees
   - Source code available
   - Community support

3. **Easy Setup**
   - Simple installer
   - One-click start/stop services
   - Clear interface

4. **Local Development**
   - Test locally before deploying
   - No internet required
   - Safe experimentation

5. **Good Documentation**
   - Tutorials available
   - Community help
   - Error messages clear

**Installation:**
- Download from apachefriends.org
- Run installer
- Start Apache & MySQL
- Access localhost
- Ready to develop!

---

## 5. PROJECT WORKFLOW

### Q13: Walk us through the complete process when a user places an order. What happens in the database?
**Answer:**
**Step-by-Step Order Process:**

**Step 1: User Browses Menu (index.php)**
```
- User sees all food items from FOOD table
- SELECT * FROM food;
- 5 items displayed: Pizza, Biryani, Butter Chicken, etc.
```

**Step 2: User Adds Item to Cart (POST request)**
```php
$_SESSION['cart'][1] = 2;  // Pizza, Qty 2
$_SESSION['cart'][2] = 1;  // Biryani, Qty 1
// Cart exists only in session (not in DB yet)
```

**Step 3: User Reviews Cart (cart.php)**
```
- Display SESSION['cart'] items
- Query FOOD table for prices
- Calculate: Total = (350 × 2) + (280 × 1) = 910
- User can modify quantities or remove items
```

**Step 4: User Clicks "Checkout" (place_order.php)**
```
- Show order summary
- Confirm button available
```

**Step 5: User Confirms Order (POST request)**
```sql
-- Transaction begins:

-- 1. Create order record
INSERT INTO orders (user_id, total_amount, status) 
VALUES (1, 910.00, 'Pending');
-- Result: order_id = 1

-- 2. Add order line items
INSERT INTO order_details (order_id, food_id, quantity, price)
VALUES (1, 1, 2, 350.00);
INSERT INTO order_details (order_id, food_id, quantity, price)
VALUES (1, 2, 1, 280.00);

-- 3. Clear cart from session
unset($_SESSION['cart']);

-- Transaction complete!
```

**Database State After Order:**
```
ORDERS Table:
order_id | user_id | total_amount | status  | created_at
1        | 1       | 910.00       | Pending | 2024-04-28

ORDER_DETAILS Table:
order_detail_id | order_id | food_id | quantity | price
1               | 1        | 1       | 2        | 350.00
2               | 1        | 2       | 1        | 280.00
```

**Step 6: Display Order Summary (order_summary.php)**
```
- Show Order ID: #00001
- Show items, quantities, total
- Status: Pending
- Redirect user to homepage
```

### Q14: How does the admin update order status? Explain the SQL query executed.
**Answer:**
**Admin Order Update Process:**

**Step 1: Admin Views Dashboard**
```sql
-- Query all orders with customer names:
SELECT o.*, u.name FROM orders o 
JOIN users u ON o.user_id = u.user_id 
ORDER BY o.created_at DESC;

-- Results in:
order_id | user_id | total | status  | user_name
1        | 1       | 910   | Pending | John Doe
2        | 2       | 350   | Pending | Sarah Johnson
```

**Step 2: Admin Clicks "Mark as Completed"**
```
- Click on Order #1
- Click "Mark as Completed" button
- Executes: update_status.php?order_id=1
```

**Step 3: Database Update**
```sql
UPDATE orders 
SET status = 'Completed' 
WHERE order_id = 1;

-- Before update:
order_id | status
1        | Pending

-- After update:
order_id | status
1        | Completed
```

**Step 4: Confirmation**
```
- Status changed in DB
- Admin dashboard refreshed
- Order row now shows "Completed" with green badge
- "Mark as Completed" button no longer visible (only for Pending)
```

### Q15: Explain how a new food item is added by the admin and its impact on the database.
**Answer:**
**Food Item Addition Process:**

**Step 1: Admin Access Add Food Page (add_food.php)**
- Form with fields:
  - Food Name (text input)
  - Description (text input)
  - Price (number input)

**Step 2: Admin Enters Data**
```
Food Name: Tea
Description: Hot refreshing tea
Price: 40.00
```

**Step 3: Form Submission (POST request)**
```php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $food_name = "Tea";
    $description = "Hot refreshing tea";
    $price = 40.00;
    
    // Validation:
    if (empty($food_name)) die("Name required");
    if (empty($price)) die("Price required");
    if (!is_numeric($price) || $price <= 0) die("Invalid price");
}
```

**Step 4: Insert into FOOD Table**
```sql
INSERT INTO food (food_name, price, description, created_at)
VALUES ('Tea', 40.00, 'Hot refreshing tea', CURRENT_TIMESTAMP);

-- FOOD Table after insertion:
food_id | food_name           | price | description               | created_at
1       | Margherita Pizza    | 350   | Classic pizza...          | 2024-04-28...
2       | Biryani             | 280   | Fragrant rice dish...     | 2024-04-28...
3       | Butter Chicken      | 320   | Creamy curry...           | 2024-04-28...
4       | Samosa              | 50    | Crispy fried pastry...    | 2024-04-28...
5       | Mango Lassi         | 80    | Refreshing yogurt drink.. | 2024-04-28...
6       | Tea                 | 40    | Hot refreshing tea        | 2024-04-28...  -- NEW!
```

**Step 5: Visibility**
- New item appears in user menu (index.php)
- Listed in admin food management (view_food.php)
- Can be added to orders by customers
- Can be deleted (if not in any order)

**Important Constraint:**
```sql
-- If we try to delete a food item that's been ordered:
SELECT COUNT(*) FROM order_details WHERE food_id = 1;
-- Returns: 2 (this item has been ordered twice)
-- Result: Cannot delete (referential integrity constraint)
```

---

## ADDITIONAL IMPORTANT CONCEPTS

### Additional Q1: Explain the difference between primary key and foreign key.
**Answer:**
**Primary Key (PK):**
- Unique identifier for each record in a table
- Example: user_id in USERS table
- Rules:
  - Must be unique (no duplicates)
  - Cannot be NULL
  - Only one per table
- Purpose: Identify each record uniquely

**Foreign Key (FK):**
- Links to primary key in another table
- Example: user_id in ORDERS table (references USERS.user_id)
- Rules:
  - Must exist in referenced table
  - Can have duplicates
  - Can be NULL
  - Multiple per table allowed
- Purpose: Maintain relationships between tables

**Example in Our Project:**
```
USERS Table:
user_id (PK) | name          | email
1            | John Doe      | john@email.com
2            | Sarah Johnson | sarah@email.com

ORDERS Table:
order_id (PK) | user_id (FK) | total
1             | 1            | 910        -- FK points to user 1
2             | 1            | 350        -- FK points to user 1 again
3             | 2            | 280        -- FK points to user 2
```

### Additional Q2: What is the purpose of the "status" field in the ORDERS table?
**Answer:**
**Purpose of Status Field:**
Tracks the current state of an order in its lifecycle.

**Possible Status Values:**
- **Pending**: Order received, waiting to be prepared
- **Processing**: Order being prepared in kitchen
- **Completed**: Order ready/delivered
- **Cancelled**: Order cancelled by customer or admin

**Usage:**
```sql
-- Find all pending orders:
SELECT * FROM orders WHERE status = 'Pending';

-- Update order to completed:
UPDATE orders SET status = 'Completed' WHERE order_id = 1;

-- Count pending orders (for admin dashboard):
SELECT COUNT(*) FROM orders WHERE status = 'Pending';
```

**Business Logic:**
- Users can see their order status in order_summary.php
- Admins can update status in admin panel
- Helps track business operations
- Shows customer their order progress

### Additional Q3: Why do we need escaping/sanitization of user input?
**Answer:**
**Security Risk - Example:**
```php
$email = "john@email.com'; DROP TABLE users; --";
$query = "SELECT * FROM users WHERE email = '$email'";
// Executes: SELECT * FROM users WHERE email = 'john@email.com'; DROP TABLE users; --';
// Result: USERS table deleted! (SQL Injection attack)
```

**Solutions Used:**
1. **Input Validation:**
   - Check format: email, number, etc.
   - Check length: max characters
   - Check type: string, integer, etc.

2. **Input Sanitization:**
   ```php
   $email = htmlspecialchars($_POST['email']);  // Remove HTML tags
   $name = trim($_POST['name']);                // Remove whitespace
   ```

3. **Prepared Statements (Best):**
   ```php
   $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
   $stmt->bind_param("s", $email);
   $stmt->execute();
   ```

**In Our Project:**
- We use htmlspecialchars() to display data safely
- Use basic validation for email format
- For production: implement prepared statements

---

## CONCLUSION

This viva covers all important aspects of the project:
✓ Database Design & Normalization
✓ Web Application Security
✓ SQL Operations (CRUD)
✓ Session Management
✓ Technology Choices
✓ Complete Workflow

**Key Takeaways:**
- Database design follows 3NF normalization
- Session management for user authentication
- CRUD operations for data manipulation
- Security considerations (validation, escaping)
- Technology stack chosen for beginner-friendly learning

---

END OF VIVA QUESTIONS & ANSWERS
