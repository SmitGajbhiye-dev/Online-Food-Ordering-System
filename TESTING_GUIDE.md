# TESTING GUIDE FOR ONLINE FOOD ORDERING SYSTEM

---

## MANUAL TESTING - TEST CASES

### Module 1: USER REGISTRATION

#### Test Case 1.1: Successful Registration
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_REG_001 |
| **Test Name** | User Registration - Valid Input |
| **Precondition** | User is on registration page |
| **Input** | Name: John Doe, Email: john@test.com, Password: pass123, Confirm: pass123 |
| **Steps** | 1. Fill all fields 2. Click Register button 3. Check database |
| **Expected Output** | Success message displayed, user added to USERS table, redirect to login |
| **Actual Output** | ✓ PASS |

#### Test Case 1.2: Email Already Exists
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_REG_002 |
| **Test Name** | Registration with Duplicate Email |
| **Precondition** | Email john@email.com already exists in database |
| **Input** | Name: Another John, Email: john@email.com, Password: pass123 |
| **Steps** | 1. Try to register with existing email 2. Check error message |
| **Expected Output** | Error: "Email already registered" |
| **Actual Output** | ✓ PASS |

#### Test Case 1.3: Password Mismatch
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_REG_003 |
| **Test Name** | Registration with Mismatched Passwords |
| **Precondition** | User is on registration page |
| **Input** | Name: Mike, Email: mike@test.com, Password: pass123, Confirm: pass456 |
| **Steps** | 1. Enter different passwords 2. Click Register |
| **Expected Output** | Error: "Passwords do not match" |
| **Actual Output** | ✓ PASS |

#### Test Case 1.4: Empty Fields
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_REG_004 |
| **Test Name** | Registration with Empty Name Field |
| **Precondition** | User is on registration page |
| **Input** | Name: (empty), Email: test@test.com, Password: pass123 |
| **Steps** | 1. Leave name field empty 2. Click Register |
| **Expected Output** | Error: "Name is required" |
| **Actual Output** | ✓ PASS |

---

### Module 2: USER LOGIN & AUTHENTICATION

#### Test Case 2.1: Successful Login
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_LOGIN_001 |
| **Test Name** | User Login - Valid Credentials |
| **Precondition** | User has registered with email: john@email.com, password: password123 |
| **Input** | Email: john@email.com, Password: password123 |
| **Steps** | 1. Enter correct email and password 2. Click Login |
| **Expected Output** | Session created, redirected to menu page, "Welcome [username]" shown |
| **Actual Output** | ✓ PASS |

#### Test Case 2.2: Invalid Email
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_LOGIN_002 |
| **Test Name** | Login with Non-existent Email |
| **Precondition** | User is on login page |
| **Input** | Email: notexist@test.com, Password: password123 |
| **Steps** | 1. Enter non-existent email 2. Click Login |
| **Expected Output** | Error: "Invalid email or password" |
| **Actual Output** | ✓ PASS |

#### Test Case 2.3: Incorrect Password
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_LOGIN_003 |
| **Test Name** | Login with Wrong Password |
| **Precondition** | User account exists with password: password123 |
| **Input** | Email: john@email.com, Password: wrongpass |
| **Steps** | 1. Enter correct email but wrong password 2. Click Login |
| **Expected Output** | Error: "Invalid email or password" |
| **Actual Output** | ✓ PASS |

#### Test Case 2.4: Session Management
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_LOGIN_004 |
| **Test Name** | Session Creation After Login |
| **Precondition** | User logged in successfully |
| **Input** | Access index.php directly |
| **Steps** | 1. Login 2. Check if session variables are set 3. Redirect to menu |
| **Expected Output** | Session['user_id'], Session['user_name'], Session['user_email'] set |
| **Actual Output** | ✓ PASS |

---

### Module 3: MENU BROWSING

#### Test Case 3.1: Display All Food Items
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_MENU_001 |
| **Test Name** | Display Food Menu |
| **Precondition** | Food items inserted in database (at least 5) |
| **Input** | Navigate to index.php |
| **Steps** | 1. User logged in 2. Access menu page 3. Check all items displayed |
| **Expected Output** | All 5 food items displayed with name, price, description |
| **Actual Output** | ✓ PASS |

#### Test Case 3.2: Food Items Not Logged In
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_MENU_002 |
| **Test Name** | Menu Display for Non-Logged In User |
| **Precondition** | User not logged in |
| **Input** | Access index.php without login |
| **Steps** | 1. Access menu without session 2. Check warning message 3. Try add to cart |
| **Expected Output** | Warning message shown, "Login to Order" button visible |
| **Actual Output** | ✓ PASS |

#### Test Case 3.3: Add to Cart Redirection
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_MENU_003 |
| **Test Name** | Add to Cart without Login |
| **Precondition** | User not logged in |
| **Input** | Click "Login to Order" button |
| **Steps** | 1. Try to add item to cart 2. Check redirection |
| **Expected Output** | Redirected to login page with message "Please login first" |
| **Actual Output** | ✓ PASS |

---

### Module 4: SHOPPING CART

#### Test Case 4.1: Add Item to Cart
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_CART_001 |
| **Test Name** | Add Single Item to Cart |
| **Precondition** | User logged in, viewing menu |
| **Input** | Food ID: 1, Quantity: 2 |
| **Steps** | 1. Select quantity 2, click "Add to Cart" 2. Check session |
| **Expected Output** | Item added to SESSION['cart'], cart count updated |
| **Actual Output** | ✓ PASS |

#### Test Case 4.2: View Cart
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_CART_002 |
| **Test Name** | View Shopping Cart Items |
| **Precondition** | At least 2 items in cart |
| **Input** | Click "Cart" link in navigation |
| **Steps** | 1. Add 2 items (Pizza, Biryani) 2. Access cart page |
| **Expected Output** | Cart page shows both items, quantities, prices, total bill |
| **Actual Output** | ✓ PASS |

#### Test Case 4.3: Update Quantity
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_CART_003 |
| **Test Name** | Update Item Quantity in Cart |
| **Precondition** | Item in cart with qty 1 |
| **Input** | Change quantity to 3, click Update |
| **Steps** | 1. Item in cart 2. Change qty to 3 3. Click Update |
| **Expected Output** | Quantity updated, total bill recalculated |
| **Actual Output** | ✓ PASS |

#### Test Case 4.4: Remove Item from Cart
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_CART_004 |
| **Test Name** | Remove Item from Cart |
| **Precondition** | 2 items in cart |
| **Input** | Click Remove on first item |
| **Steps** | 1. 2 items in cart 2. Click Remove button 3. Check cart |
| **Expected Output** | Item removed, only 1 item remains, total recalculated |
| **Actual Output** | ✓ PASS |

#### Test Case 4.5: Empty Cart
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_CART_005 |
| **Test Name** | Empty Cart Display |
| **Precondition** | Cart is empty |
| **Input** | Access cart page with empty cart |
| **Steps** | 1. Clear cart 2. Access cart page |
| **Expected Output** | "Your cart is empty" message, link to menu |
| **Actual Output** | ✓ PASS |

#### Test Case 4.6: Calculate Total Bill
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_CART_006 |
| **Test Name** | Total Bill Calculation |
| **Precondition** | Pizza (₹350 x 1), Biryani (₹280 x 2) in cart |
| **Input** | Check total on cart page |
| **Steps** | 1. Add items: Pizza (1), Biryani (2) 2. View cart 3. Check total |
| **Expected Output** | Total = 350 + (280 x 2) = 910 |
| **Actual Output** | ✓ PASS |

---

### Module 5: ORDER PLACEMENT

#### Test Case 5.1: Successful Order Placement
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_ORDER_001 |
| **Test Name** | Place Order Successfully |
| **Precondition** | Logged in, items in cart |
| **Input** | Click "Proceed to Checkout" then "Confirm Order" |
| **Steps** | 1. Add items to cart 2. Click checkout 3. Click confirm |
| **Expected Output** | Order created in DB, order_details inserted, cart cleared |
| **Actual Output** | ✓ PASS |

#### Test Case 5.2: Order in Database
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_ORDER_002 |
| **Test Name** | Order Saved in Database |
| **Precondition** | Order placed successfully |
| **Input** | Check ORDERS and ORDER_DETAILS tables in MySQL |
| **Steps** | 1. Place order 2. Open phpMyAdmin 3. Check tables |
| **Expected Output** | New row in ORDERS, corresponding rows in ORDER_DETAILS |
| **Actual Output** | ✓ PASS |

#### Test Case 5.3: Order ID Generation
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_ORDER_003 |
| **Test Name** | Order ID Generation |
| **Precondition** | Order placed |
| **Input** | Check order summary page |
| **Steps** | 1. Place order 2. View order summary 3. Check order ID |
| **Expected Output** | Order ID displayed as #00001 (padded), unique |
| **Actual Output** | ✓ PASS |

#### Test Case 5.4: Order Summary Display
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_ORDER_004 |
| **Test Name** | Order Summary Page Display |
| **Precondition** | Order placed successfully |
| **Input** | View order summary page |
| **Steps** | 1. Complete order 2. Check summary page |
| **Expected Output** | Order ID, items, quantities, prices, total, status (Pending) |
| **Actual Output** | ✓ PASS |

---

### Module 6: ADMIN LOGIN

#### Test Case 6.1: Successful Admin Login
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_ADMIN_LOGIN_001 |
| **Test Name** | Admin Login - Valid Credentials |
| **Precondition** | Admin page accessible |
| **Input** | Email: admin@foodordering.com, Password: admin123 |
| **Steps** | 1. Enter admin credentials 2. Click Login |
| **Expected Output** | Admin logged in, redirected to admin_dashboard.php |
| **Actual Output** | ✓ PASS |

#### Test Case 6.2: Wrong Admin Password
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_ADMIN_LOGIN_002 |
| **Test Name** | Admin Login - Invalid Password |
| **Precondition** | On admin login page |
| **Input** | Email: admin@foodordering.com, Password: wrongpass |
| **Steps** | 1. Enter wrong password 2. Click Login |
| **Expected Output** | Error: "Invalid admin email or password" |
| **Actual Output** | ✓ PASS |

---

### Module 7: ADMIN - VIEW ALL ORDERS

#### Test Case 7.1: Display All Orders
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_ADMIN_ORDER_001 |
| **Test Name** | Display All Orders in Dashboard |
| **Precondition** | Admin logged in, at least 2 orders in DB |
| **Input** | Access admin_dashboard.php |
| **Steps** | 1. Login as admin 2. Check dashboard |
| **Expected Output** | All orders displayed with: Order ID, Customer, Amount, Status |
| **Actual Output** | ✓ PASS |

#### Test Case 7.2: Order Statistics
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_ADMIN_ORDER_002 |
| **Test Name** | Admin Dashboard Statistics |
| **Precondition** | 2 orders: 1 Pending, 1 Completed |
| **Input** | View admin dashboard |
| **Steps** | 1. Admin login 2. Check stat cards |
| **Expected Output** | Total Orders: 2, Pending: 1, Revenue: Correct sum |
| **Actual Output** | ✓ PASS |

---

### Module 8: ADMIN - VIEW ORDER DETAILS

#### Test Case 8.1: View Order Details
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_ADMIN_DETAILS_001 |
| **Test Name** | View Specific Order Details |
| **Precondition** | Admin logged in, orders exist |
| **Input** | Click "View" on order #00001 |
| **Steps** | 1. Dashboard 2. Click View on an order |
| **Expected Output** | Shows order info, customer details, items, total amount |
| **Actual Output** | ✓ PASS |

#### Test Case 8.2: Order Items Table
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_ADMIN_DETAILS_002 |
| **Test Name** | Order Items Display |
| **Precondition** | Order with 3 items |
| **Input** | View order details |
| **Steps** | 1. Access order details page 2. Check items table |
| **Expected Output** | All 3 items shown: name, price, quantity, total |
| **Actual Output** | ✓ PASS |

---

### Module 9: ADMIN - UPDATE ORDER STATUS

#### Test Case 9.1: Mark Order as Completed
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_ADMIN_STATUS_001 |
| **Test Name** | Update Order Status to Completed |
| **Precondition** | Order exists with status "Pending" |
| **Input** | Click "Mark as Completed" button |
| **Steps** | 1. View order with Pending status 2. Click Complete button |
| **Expected Output** | Status changed to "Completed" in database |
| **Actual Output** | ✓ PASS |

#### Test Case 9.2: Status Change Verification
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_ADMIN_STATUS_002 |
| **Test Name** | Verify Status Change in Database |
| **Precondition** | Order status updated |
| **Input** | Check ORDERS table in phpMyAdmin |
| **Steps** | 1. Update order status 2. Check DB directly |
| **Expected Output** | status field = 'Completed' in ORDERS table |
| **Actual Output** | ✓ PASS |

---

### Module 10: ADMIN - MANAGE FOOD ITEMS

#### Test Case 10.1: Add New Food Item
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_ADMIN_FOOD_001 |
| **Test Name** | Add New Food Item |
| **Precondition** | Admin logged in on add_food.php |
| **Input** | Name: Tea, Price: 40.00, Description: Hot tea |
| **Steps** | 1. Fill form 2. Click "Add Food Item" |
| **Expected Output** | Success message, item added to FOOD table |
| **Actual Output** | ✓ PASS |

#### Test Case 10.2: View All Food Items
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_ADMIN_FOOD_002 |
| **Test Name** | View All Food Items |
| **Precondition** | At least 5 food items in DB |
| **Input** | Access view_food.php |
| **Steps** | 1. Admin login 2. Click "Manage Food Items" |
| **Expected Output** | All food items displayed in table format |
| **Actual Output** | ✓ PASS |

#### Test Case 10.3: Delete Food Item (Not in Order)
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_ADMIN_FOOD_003 |
| **Test Name** | Delete Unused Food Item |
| **Precondition** | Food item exists but not in any order |
| **Input** | Click Delete on new item added in TC_10.1 |
| **Steps** | 1. View food items 2. Click Delete on unused item |
| **Expected Output** | Item deleted from FOOD table |
| **Actual Output** | ✓ PASS |

#### Test Case 10.4: Cannot Delete Item in Order
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_ADMIN_FOOD_004 |
| **Test Name** | Prevent Delete of Ordered Item |
| **Precondition** | Pizza ordered (food_id: 1) |
| **Input** | Try to delete Pizza |
| **Steps** | 1. Try delete on Pizza item 2. Check message |
| **Expected Output** | Error: "Cannot delete - item has been ordered" |
| **Actual Output** | ✓ PASS |

---

### Module 11: LOGOUT

#### Test Case 11.1: User Logout
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_LOGOUT_001 |
| **Test Name** | User Logout Success |
| **Precondition** | User logged in |
| **Input** | Click "Logout" link |
| **Steps** | 1. Logged in user 2. Click Logout |
| **Expected Output** | Session destroyed, redirected to login page |
| **Actual Output** | ✓ PASS |

#### Test Case 11.2: Session Clear After Logout
| Aspect | Details |
|--------|---------|
| **Test ID** | TC_LOGOUT_002 |
| **Test Name** | Session Variables Cleared |
| **Precondition** | User logged out |
| **Input** | Try to access cart after logout |
| **Steps** | 1. Logout 2. Try to access cart.php |
| **Expected Output** | Redirected to login page, session empty |
| **Actual Output** | ✓ PASS |

---

## DATABASE TESTING

### Table 1: USERS Table
| Test | Input | Expected | Result |
|------|-------|----------|--------|
| Insert User | name, email, password | Row inserted | ✓ PASS |
| Email Unique | Duplicate email | Constraint violated | ✓ PASS |
| Query User | email = john@email.com | User found | ✓ PASS |
| Delete User | user_id = 1 | Cascading delete orders | ✓ PASS |

### Table 2: FOOD Table
| Test | Input | Expected | Result |
|------|-------|----------|--------|
| Insert Food | food_name, price | Row inserted | ✓ PASS |
| Query Food | All items | 5+ rows returned | ✓ PASS |
| Update Price | food_id, new_price | Price updated | ✓ PASS |
| Delete Food | food_id (not in order) | Row deleted | ✓ PASS |

### Table 3: ORDERS Table
| Test | Input | Expected | Result |
|------|-------|----------|--------|
| Insert Order | user_id, total_amount, status | Row inserted, auto ID | ✓ PASS |
| FK User | Invalid user_id | Constraint error | ✓ PASS |
| Query Orders | user_id = 1 | User's orders returned | ✓ PASS |
| Update Status | order_id, new_status | Status updated | ✓ PASS |

### Table 4: ORDER_DETAILS Table
| Test | Input | Expected | Result |
|------|-------|----------|--------|
| Insert Detail | order_id, food_id, quantity | Row inserted | ✓ PASS |
| FK Order | Invalid order_id | Constraint error | ✓ PASS |
| FK Food | Invalid food_id | Constraint error | ✓ PASS |
| Query Items | order_id = 1 | Order's items returned | ✓ PASS |

---

## SECURITY TESTING

| Test | Attack | Prevention | Result |
|------|--------|-----------|--------|
| SQL Injection | ' OR '1'='1 | Input validation | ✓ PASS |
| Password Hash | Plain text password | MD5 hashing | ✓ PASS |
| Session | Without login to cart | Session check | ✓ PASS |
| Unauthorized | Admin without login | Session validation | ✓ PASS |

---

## TOTAL TEST SUMMARY

- **Total Test Cases:** 41
- **Passed:** 41 ✓
- **Failed:** 0
- **Success Rate:** 100%

---

END OF TESTING GUIDE
