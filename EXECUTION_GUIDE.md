# STEP-BY-STEP EXECUTION GUIDE

## ONLINE FOOD ORDERING SYSTEM

---

## PREREQUISITES

- Windows/Mac/Linux computer
- Internet connection (for downloading XAMPP)
- Basic understanding of file management
- Text editor (Notepad/VS Code) - optional

---

## STEP 1: INSTALL XAMPP

### What is XAMPP?
XAMPP is an all-in-one package that includes Apache (web server), MySQL (database), PHP (programming language), and phpMyAdmin (database management tool).

### Installation Steps:

1. **Download XAMPP**
   - Visit: https://www.apachefriends.org/
   - Click "Download" (Choose version for your OS - Windows/Mac/Linux)
   - Choose PHP version 7.4 or higher

2. **Install XAMPP**
   - Run the downloaded installer (.exe file)
   - Select installation location (default: C:\xampp)
   - Click Next → Install
   - Wait for installation to complete
   - Installation complete!

3. **Verify Installation**
   - Open XAMPP Control Panel
   - Should show modules like Apache, MySQL, etc.

---

## STEP 2: START APACHE & MYSQL

### Using XAMPP Control Panel:

1. **Open XAMPP Control Panel**
   - Windows: Click Start Menu → XAMPP Control Panel
   - Or: Navigate to C:\xampp\xampp-control.exe and double-click

2. **Start Services**
   ```
   Apache Module:
   - Locate "Apache" row
   - Click "Start" button
   - Status should change to "Running" (green)
   
   MySQL Module:
   - Locate "MySQL" row
   - Click "Start" button
   - Status should change to "Running" (green)
   ```

3. **Verify Services Running**
   - Open browser (Chrome, Firefox, Edge)
   - URL: http://localhost
   - Should see XAMPP Dashboard page
   - Status: ✓ Apache Running, ✓ MySQL Running

---

## STEP 3: ACCESS phpMyADMIN

### Open Database Management Tool:

1. **Method 1 - Via XAMPP Control Panel**
   - Open XAMPP Control Panel
   - Locate MySQL
   - Click "Admin" button
   - Opens phpMyAdmin in browser

2. **Method 2 - Direct URL**
   - Open browser
   - URL: http://localhost/phpmyadmin
   - Should see phpMyAdmin interface

### phpMyAdmin Interface:
```
Left Panel: Database list
Top Menu: File, Edit, View, etc.
Main Area: Create/manage databases and tables
```

---

## STEP 4: CREATE DATABASE

### Using phpMyAdmin:

1. **Create New Database**
   - Click "New" button (Top-left)
   - Enter Database name: `food_ordering`
   - Click "Create"
   - Success: "Database food_ordering created successfully"

2. **Import SQL Schema**
   - Click on `food_ordering` database (left panel)
   - Click "Import" tab (top menu)
   - Choose file: `database.sql` (from project folder)
   - Click "Go"
   - Success: "Import has been successfully finished"

### Tables Created:
- ✓ users
- ✓ food
- ✓ orders
- ✓ order_details

### Verify Tables:
- Click on `food_ordering` database
- View all tables in left panel
- Should see 4 tables listed

---

## STEP 5: COPY PROJECT FILES

### Copy Food Ordering Folder:

1. **Locate Project Files**
   - Your project folder: `food-ordering`
   - Contains: all PHP files, CSS file, SQL file, etc.

2. **Locate XAMPP htdocs Folder**
   - Default location: `C:\xampp\htdocs`
   - This is where web files are served from

3. **Copy Project Folder**
   - Copy entire `food-ordering` folder
   - Paste into `C:\xampp\htdocs`
   - Result: `C:\xampp\htdocs\food-ordering`

4. **Verify Files**
   - Open `C:\xampp\htdocs\food-ordering`
   - Should contain:
     ```
     ├── db.php
     ├── index.php
     ├── register.php
     ├── login.php
     ├── logout.php
     ├── cart.php
     ├── place_order.php
     ├── order_summary.php
     ├── admin.php
     ├── admin_dashboard.php
     ├── add_food.php
     ├── view_food.php
     ├── delete_food.php
     ├── update_status.php
     ├── view_order_details.php
     ├── admin_logout.php
     ├── style.css
     └── database.sql
     ```

---

## STEP 6: RUN THE PROJECT

### Access Project in Browser:

1. **Start Apache & MySQL** (if not already running)
   - Open XAMPP Control Panel
   - Click "Start" on Apache and MySQL

2. **Open Browser**
   - Chrome, Firefox, Safari, Edge, etc.
   - URL: http://localhost/food-ordering/
   - Press Enter

3. **Welcome Page**
   - Should see homepage with navigation menu
   - Options: Home, Login, Register
   - If admin: see "Admin Panel" link

---

## STEP 7: BASIC WORKFLOW

### User Registration & Login:

```
1. REGISTER
   - Click "Register" link
   - Fill form: Name, Email, Password
   - Click "Register" button
   - Success message shown

2. LOGIN
   - Return to login page
   - Enter registered email & password
   - Click "Login"
   - Logged in to menu page

3. BROWSE MENU
   - See all 5 food items
   - Each shows: Name, Price, Description
   - Quantity option available

4. ADD TO CART
   - Select food item
   - Enter quantity
   - Click "Add to Cart"
   - Item added to session cart

5. VIEW CART
   - Click "Cart" link in navigation
   - See all cart items
   - Shows: Item, Price, Quantity, Total
   - Can update quantity or remove items

6. CHECKOUT
   - Click "Proceed to Checkout"
   - Review order summary
   - Click "Confirm Order"
   - Order placed successfully!

7. ORDER SUMMARY
   - Order ID shown: #00001 (example)
   - Items list displayed
   - Total amount shown
   - Status: "Pending"

8. LOGOUT
   - Click "Logout" link
   - Session destroyed
   - Redirected to login
```

### Admin Workflow:

```
1. ADMIN LOGIN
   - Go to http://localhost/food-ordering/admin.php
   - Email: admin@foodordering.com
   - Password: admin123
   - Click "Login to Admin Panel"

2. DASHBOARD
   - See statistics cards: Total Orders, Pending, Revenue, Items
   - View all orders in table
   - Options: View, Complete order

3. VIEW ORDER DETAILS
   - Click "View" on any order
   - See customer info, items, total

4. UPDATE ORDER STATUS
   - Click "Mark as Completed"
   - Order status changed to "Completed"
   - Back to dashboard

5. ADD FOOD ITEM
   - Click "Add Food Item" (navigation)
   - Fill: Food Name, Price, Description
   - Click "Add Food Item"
   - Item added to menu

6. MANAGE FOOD
   - Click "Manage Food Items"
   - See all food items
   - Click "Delete" to remove (if not ordered)

7. LOGOUT
   - Click "Logout"
   - Admin session destroyed
```

---

## TROUBLESHOOTING

### Problem 1: "Connection Failed: Unable to connect to localhost"
**Solution:**
- Start MySQL service from XAMPP Control Panel
- Check if port 3306 is not blocked
- Restart MySQL service

### Problem 2: "Database not found"
**Solution:**
- Ensure database.sql was imported
- Check phpMyAdmin for `food_ordering` database
- Re-import SQL file if needed

### Problem 3: "Access Denied" when accessing pages
**Solution:**
- Check if Apache is running
- Verify project folder is in C:\xampp\htdocs
- Check URL: http://localhost/food-ordering/

### Problem 4: Session not working
**Solution:**
- Ensure php.ini has session support enabled
- Clear browser cookies
- Try different browser
- Restart Apache

### Problem 5: Database files not visible in phpMyAdmin
**Solution:**
- Refresh the page
- Restart MySQL service
- Check database.sql import was successful

---

## TESTING THE PROJECT

### Quick Test Checklist:

- [ ] Homepage loads successfully
- [ ] Registration works (new user created)
- [ ] Login works (user session created)
- [ ] Menu displays all 5 food items
- [ ] Add to cart works
- [ ] Cart shows correct total
- [ ] Checkout successful
- [ ] Order appears in admin panel
- [ ] Admin can update order status
- [ ] Admin can add new food item
- [ ] Logout works (session cleared)

---

## EXPECTED OUTPUTS

### User Registration Page:
```
Header: "Online Food Ordering System - Create Your Account"
Form with fields:
- Full Name (text)
- Email Address (email)
- Password (password)
- Confirm Password (password)
Button: "Register"
Links: "Login here", "Home", "Register"
```

### Login Page:
```
Header: "Online Food Ordering System - User Login"
Form with fields:
- Email Address
- Password
Button: "Login to Admin Panel"
Demo credentials displayed
Links: "Home", "Login", "Register", "Admin Panel"
```

### Menu/Home Page:
```
Header: "Online Food Ordering System - Order Your Favorite Food Online"
Navigation: Menu, Cart, Logout, Welcome [Username]
Content: "Available Food Menu"
Food items in cards:
- Food Name
- Description
- Price (₹350.00, etc.)
- Quantity input
- "Add to Cart" button
Grid layout with multiple items
```

### Cart Page:
```
Header: "Online Food Ordering System - Your Shopping Cart"
Table showing:
- Column: Food Item, Price, Quantity, Total, Action
- Rows: Each cart item
- Update and Remove buttons
Summary box:
- Subtotal: ₹XXX
- Delivery Charge: ₹0
- Total Bill: ₹XXX
Buttons: "Continue Shopping", "Proceed to Checkout"
```

### Order Summary Page:
```
Green success banner: "Order Confirmed!"
Order Information box:
- Order ID: #00001
- Order Date: 28-Apr-2024 14:30
- Status: Pending
Order Items table:
- Item names, prices, quantities, totals
Bill Summary:
- Subtotal, Delivery, Total
Buttons: "Continue Shopping", "Logout"
```

### Admin Dashboard:
```
Header: "Online Food Ordering System - Admin Panel"
Statistics Cards showing:
- 📦 Total Orders
- ⏳ Pending Orders
- 💰 Total Revenue
- 🍽️ Food Items
Orders Table:
- Order ID, Customer Name, Amount, Status, Actions
Navigation: Dashboard, Add Food Item, Manage Food Items, Logout
```

---

## IMPORTANT NOTES

### Security:
- This is a LEARNING PROJECT
- DO NOT use in production without security enhancements
- Use bcrypt for password hashing in production
- Use parameterized queries to prevent SQL injection
- Implement CSRF tokens for forms

### Database:
- XAMPP default credentials: root (no password)
- Change admin credentials in admin.php for deployment
- Always backup database before deletion

### Performance:
- This project is for learning, not production
- For large datasets, optimize queries with indexes
- Consider pagination for order list

### Backup Database:
1. Open phpMyAdmin
2. Click on `food_ordering` database
3. Click "Export"
4. Click "Go"
5. SQL file downloaded as backup

---

## NEXT STEPS FOR ENHANCEMENT

1. **Add User Profiles** - Store address, phone number
2. **Payment Integration** - Integrate payment gateway
3. **Email Notifications** - Send order confirmation emails
4. **Order Tracking** - Real-time order status updates
5. **Rating System** - Allow customers to rate food items
6. **Search Functionality** - Search for food items
7. **Filtering** - Filter by price, category, rating
8. **Mobile App** - Develop mobile version
9. **Dashboard Analytics** - More detailed sales reports
10. **Multi-language Support** - Support multiple languages

---

## GETTING HELP

### Common Resources:
- PHP Documentation: https://www.php.net/docs.php
- MySQL Documentation: https://dev.mysql.com/doc/
- XAMPP Support: https://community.apachefriends.org/
- W3Schools Tutorials: https://www.w3schools.com/
- Stack Overflow: https://stackoverflow.com/

### Project Issues:
- Check error messages in browser console
- Check XAMPP error logs in C:\xampp\apache\logs\
- Verify database is running in phpMyAdmin
- Check PHP syntax errors in VS Code

---

## SUMMARY

Successfully running the Online Food Ordering System involves:
1. ✓ Installing XAMPP
2. ✓ Starting Apache & MySQL
3. ✓ Creating database with SQL schema
4. ✓ Copying project files to htdocs
5. ✓ Accessing via http://localhost/food-ordering/
6. ✓ Testing user and admin features

**Status: Ready for Production Learning & Development**

---

END OF EXECUTION GUIDE
