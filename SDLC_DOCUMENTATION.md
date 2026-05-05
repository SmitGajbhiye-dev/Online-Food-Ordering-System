# SDLC DOCUMENTATION FOR ONLINE FOOD ORDERING SYSTEM

---

## 1. PROBLEM STATEMENT

### Current Scenario:
- **Traditional food ordering** relies on phone calls or manual walk-ins
- **Inefficient process** - no real-time order tracking for customers
- **Manual management** - administrators manually track orders
- **Limited accessibility** - only during business hours
- **Error-prone** - manual note-taking leads to order mistakes
- **No data management** - difficult to analyze sales and customer preferences

### Problem:
Design and develop an **online food ordering system** that allows customers to browse a menu, place orders online, and allows administrators to manage food items and track orders efficiently. The system should be **beginner-friendly** for second-year engineering students to understand database design, web development, and SDLC principles.

---

## 2. OBJECTIVES

### Primary Objectives:
1. **Enable Online Ordering** - Allow customers to browse food items and place orders 24/7
2. **Automate Order Management** - Provide admins with tools to manage orders and update status
3. **Data Persistence** - Store all user, food, and order information in a database
4. **User Authentication** - Ensure secure login and registration for users
5. **Real-time Tracking** - Display order status to customers

### Secondary Objectives:
1. Teach database design and normalization concepts
2. Implement SDLC methodology in a practical project
3. Practice web development with PHP, MySQL, HTML, CSS, and JavaScript
4. Demonstrate understanding of E-R modeling and relational databases
5. Show version control and project documentation skills

---

## 3. FEASIBILITY STUDY

### 3.1 TECHNICAL FEASIBILITY ✅ YES

**Technology Stack Used:**
- **Frontend:** HTML, CSS, JavaScript (Beginner-friendly)
- **Backend:** PHP (Procedural - easy to learn)
- **Database:** MySQL (Standard database)
- **Server:** XAMPP (Free, easy installation)
- **Web Browser:** Any modern browser

**Advantages:**
- All technologies are open-source and free
- Easy to learn for second-year students
- No complex dependencies or frameworks required
- Quick development and deployment
- Good documentation available online

**Challenges:**
- Limited scalability for large projects
- No built-in security features (need manual implementation)
- Performance issues with large databases

---

### 3.2 OPERATIONAL FEASIBILITY ✅ YES

**User Requirements:**
- Customers need basic computer literacy
- Admin should understand food management
- Both should be comfortable using web browsers

**Resource Requirements:**
- Personal computer with XAMPP installed
- Internet connection (optional, for learning resources)
- Database design knowledge (part of curriculum)

**Skills Needed:**
- Basic HTML/CSS knowledge
- PHP programming
- MySQL database management
- Web development concepts

---

### 3.3 ECONOMIC FEASIBILITY ✅ YES

**Cost Analysis:**
- **Software Cost:** ₹0 (All free and open-source)
- **Hardware Cost:** Standard computer (₹30,000+)
- **Infrastructure Cost:** ₹0 (Local development)
- **Maintenance Cost:** Minimal (only bug fixes)

**Benefits:**
- No licensing fees
- Reduced operational costs
- Increased customer satisfaction
- Better order accuracy
- Improved business analytics

**ROI Justification:**
- Easy to implement
- Quick payback period
- Improves business efficiency
- Scalable for future expansion

---

## 4. SOFTWARE REQUIREMENT SPECIFICATION (SRS)

### 4.1 FUNCTIONAL REQUIREMENTS

#### User (Customer) Features:
1. **User Registration**
   - Input: Name, Email, Password
   - Validation: Check email uniqueness, password match
   - Output: Account created, redirect to login

2. **User Login**
   - Input: Email, Password
   - Validation: Check credentials in database
   - Output: Session created, redirect to menu

3. **Browse Menu**
   - Display all food items with name, price
   - Show food description
   - Fetch from food table in database

4. **Add to Cart**
   - Select item and quantity
   - Store in session (cart array)
   - Allow multiple items

5. **View Cart**
   - Display cart items with prices
   - Show total bill
   - Allow edit quantity, remove items

6. **Place Order**
   - Create order in orders table
   - Insert items in order_details table
   - Clear cart after success
   - Generate order ID

7. **View Order Summary**
   - Display order confirmation
   - Show order ID, items, total
   - Display order status and timeline

8. **User Logout**
   - Destroy session
   - Clear cart
   - Redirect to login page

#### Admin Features:
1. **Admin Login**
   - Input: Admin email, password
   - Hardcoded credentials for simplicity
   - Create admin session

2. **Dashboard**
   - Display total orders, pending orders
   - Show total revenue
   - Display statistics

3. **View All Orders**
   - List all orders in table format
   - Show customer name, total, status
   - Click to view order details

4. **View Order Details**
   - Show order items, quantities, prices
   - Display customer information
   - Show order date and status

5. **Update Order Status**
   - Change status from Pending to Completed
   - Update in database
   - Redirect to dashboard

6. **Add Food Item**
   - Input: Food name, price, description
   - Validate input
   - Insert into food table

7. **Manage Food Items**
   - List all food items
   - Delete food item (if not in any order)
   - Referential integrity check

8. **Admin Logout**
   - Destroy admin session
   - Redirect to admin login

---

### 4.2 NON-FUNCTIONAL REQUIREMENTS

1. **Performance:**
   - Page load time < 2 seconds
   - Database queries optimized
   - Up to 1000 concurrent users

2. **Security:**
   - Password hashing (MD5 for simplicity, bcrypt in production)
   - Session-based authentication
   - SQL injection prevention (parameterized queries)
   - Input validation and sanitization

3. **Reliability:**
   - 99% system uptime
   - Database backups
   - Error handling and logging

4. **Usability:**
   - Clean, intuitive interface
   - Easy navigation
   - Mobile-responsive design
   - Clear error messages

5. **Scalability:**
   - Support for future feature additions
   - Database normalization for expansion
   - Modular code structure

6. **Availability:**
   - 24/7 accessibility
   - No downtime for ordering
   - Instant order confirmation

---

## 5. ENTITY-RELATIONSHIP (E-R) DIAGRAM

### Entities and Relationships:

```
┌──────────────┐                      ┌──────────────┐
│    USERS     │                      │     FOOD     │
├──────────────┤                      ├──────────────┤
│ user_id (PK) │◄───────────┐         │ food_id (PK) │
│ name         │            │         │ food_name    │
│ email        │            │         │ price        │
│ password     │            │         └──────────────┘
│ created_at   │            │                 ▲
└──────────────┘            │                 │
                            │                 │
                            │        ┌────────┴────────┐
                            │        │                 │
                            │    (has many)      (has many)
                            │        │                 │
                            │        ▼                 ▼
                        ┌──────────────────┐   ┌──────────────────┐
                        │     ORDERS       │   │ ORDER_DETAILS    │
                        ├──────────────────┤   ├──────────────────┤
                        │ order_id (PK)    │   │order_detail_id(PK)
                        │ user_id (FK)◄────┼───┤ order_id (FK)    │
                        │ total_amount     │   │ food_id (FK)     │
                        │ status           │   │ quantity         │
                        │ created_at       │   │ price            │
                        └──────────────────┘   └──────────────────┘
```

### Relationship Descriptions:

1. **USERS → ORDERS** (One-to-Many)
   - One user can place multiple orders
   - Foreign key: user_id in orders table

2. **ORDERS → ORDER_DETAILS** (One-to-Many)
   - One order can have multiple line items
   - Foreign key: order_id in order_details table

3. **FOOD → ORDER_DETAILS** (One-to-Many)
   - One food item can appear in multiple orders
   - Foreign key: food_id in order_details table

---

## 6. RELATIONAL MODEL

### Normalized Tables:

#### Table 1: USERS
```
USERS(user_id, name, email, password, created_at)
Primary Key: user_id
Unique: email
```

#### Table 2: FOOD
```
FOOD(food_id, food_name, price, description, created_at)
Primary Key: food_id
```

#### Table 3: ORDERS
```
ORDERS(order_id, user_id, total_amount, status, created_at)
Primary Key: order_id
Foreign Key: user_id → USERS.user_id
```

#### Table 4: ORDER_DETAILS
```
ORDER_DETAILS(order_detail_id, order_id, food_id, quantity, price)
Primary Key: order_detail_id
Foreign Keys: 
  - order_id → ORDERS.order_id
  - food_id → FOOD.food_id
```

---

## 7. NORMALIZATION (Up to 3NF)

### First Normal Form (1NF):
**Requirement:** Remove repeating groups (all attributes have atomic values)

**Analysis:** ✅ Already in 1NF
- All attributes contain atomic values
- No repeating groups
- Each cell contains only one value

**Example:**
```
VALID (1NF):     INVALID (Not 1NF):
┌─────┬────────────┐    ┌─────┬──────────────────┐
│ ID  │ Food Names │    │ ID  │ Food Names       │
├─────┼────────────┤    ├─────┼──────────────────┤
│ 1   │ Pizza      │    │ 1   │ Pizza, Burger    │
│ 2   │ Burger     │    │ 2   │ Biryani, Samosa  │
└─────┴────────────┘    └─────┴──────────────────┘
```

---

### Second Normal Form (2NF):
**Requirement:** Must be in 1NF + Remove partial dependencies

**Analysis:** ✅ Already in 2NF
- All non-key attributes are fully dependent on the entire primary key
- In ORDERS: user_id depends on order_id (full dependency)
- In ORDER_DETAILS: quantity and price depend on both order_id and food_id

**Example:**
```
ORDERS Table:
order_id (PK) | user_id (FK) | total_amount | status
      1       |      1       |    350.00    | Pending

Dependency: total_amount and status depend FULLY on order_id
```

---

### Third Normal Form (3NF):
**Requirement:** Must be in 2NF + Remove transitive dependencies

**Analysis:** ✅ Already in 3NF
- No transitive dependencies exist
- All non-key attributes depend directly on the primary key
- No non-key attribute depends on another non-key attribute

**Example of Transitive Dependency (if existed):**
```
INVALID (Not 3NF):
order_id | user_id | user_name | user_email
   1     |    1    | John      | john@email.com

Problem: user_name depends on user_id (NOT on order_id)
         This is a transitive dependency

SOLUTION: Move to separate USERS table
```

---

## 8. DATA FLOW ANALYSIS

### Overall Data Flow in the System:

```
┌────────────────────────────────────────────────────────────┐
│                    USER DATA FLOW                           │
└────────────────────────────────────────────────────────────┘

Registration:
┌──────────┐      ┌──────────┐      ┌──────────────┐      ┌────────┐
│  User    │─────▶│register  │─────▶│ USERS Table  │─────▶│ Success│
│ Form     │      │.php      │      │   (DB)       │      │ Page   │
└──────────┘      └──────────┘      └──────────────┘      └────────┘

Login:
┌──────────┐      ┌──────────┐      ┌──────────────┐      ┌────────┐
│  User    │─────▶│ login    │─────▶│ USERS Table  │─────▶│Menu    │
│ Form     │      │ .php     │      │   (DB)       │      │ Page   │
└──────────┘      └──────────┘      └──────────────┘      └────────┘
                                            │
                                            ▼
                                     ✓ Create Session
                                     ✓ Store user_id

┌────────────────────────────────────────────────────────────┐
│                   ORDERING DATA FLOW                        │
└────────────────────────────────────────────────────────────┘

View Menu:
┌──────────┐      ┌──────────┐      ┌──────────────┐
│index.php │─────▶│ Query    │─────▶│  FOOD Table  │
│ (Menu)   │      │Database  │      │    (DB)      │
└──────────┘      └──────────┘      └──────────────┘
    ▲
    │
    └──────────────────────────────────────────
    Display: food_name, price, description

Add to Cart:
┌──────────────┐      ┌──────────┐      ┌──────────────────┐
│Select Item   │─────▶│Store to  │─────▶│ SESSION['cart']  │
│& Quantity    │      │Session   │      │ Array            │
└──────────────┘      └──────────┘      └──────────────────┘

View Cart:
┌──────────┐      ┌──────────┐      ┌──────────────────┐
│ cart.php │─────▶│Read      │─────▶│ SESSION['cart']  │
│          │      │Session   │      │ Calculate Total  │
└──────────┘      └──────────┘      └──────────────────┘

Place Order:
┌──────────┐      ┌──────────┐      ┌──────────────────┐
│checkout  │─────▶│Insert    │─────▶│ ORDERS Table     │
│ .php     │      │to DB     │      │ ORDER_DETAILS    │
└──────────┘      └──────────┘      │ Table            │
                                    └──────────────────┘
                                            │
                                            ▼
                                    ✓ Generate Order ID
                                    ✓ Clear cart session
                                    ✓ Redirect to summary

┌────────────────────────────────────────────────────────────┐
│                   ADMIN DATA FLOW                           │
└────────────────────────────────────────────────────────────┘

View Orders:
┌────────────┐      ┌──────────┐      ┌──────────────┐
│Dash board  │─────▶│Query DB  │─────▶│ORDERS Table  │
│.php        │      │          │      │JOIN with     │
└────────────┘      └──────────┘      │USERS Table   │
                                      └──────────────┘

Update Status:
┌────────────┐      ┌──────────┐      ┌──────────────┐
│Update link │─────▶│UPDATE    │─────▶│ORDERS Table  │
│            │      │Status    │      │status changed│
└────────────┘      └──────────┘      └──────────────┘

Add Food Item:
┌────────────┐      ┌──────────┐      ┌──────────────┐
│ Add Food   │─────▶│INSERT    │─────▶│  FOOD Table  │
│ Form       │      │to DB     │      │ New item     │
└────────────┘      └──────────┘      └──────────────┘

Delete Food Item:
┌────────────┐      ┌──────────┐      ┌──────────────┐
│ Delete     │─────▶│Check     │─────▶│  FOOD Table  │
│ Link       │      │Reference │      │ Item deleted │
└────────────┘      └──────────┘      └──────────────┘
```

---

## 9. SYSTEM ARCHITECTURE

### 3-Tier Architecture:

```
┌─────────────────────────────────────────────────────┐
│                PRESENTATION LAYER                    │
│  (HTML Pages: index.php, login.php, register.php)  │
│           (User Interface - Browser)                │
└─────────────────────────────────────────────────────┘
                        │
                        ▼
┌─────────────────────────────────────────────────────┐
│              BUSINESS LOGIC LAYER                    │
│  (PHP Controller Logic: cart.php, place_order.php)  │
│         (Session Management, Validation)           │
└─────────────────────────────────────────────────────┘
                        │
                        ▼
┌─────────────────────────────────────────────────────┐
│              DATA ACCESS LAYER                       │
│    (Database Connection: db.php, MySQL Queries)    │
│         (CRUD Operations on Database)              │
└─────────────────────────────────────────────────────┘
                        │
                        ▼
┌─────────────────────────────────────────────────────┐
│              DATABASE LAYER                          │
│   (MySQL Database: food_ordering)                  │
│  (Tables: users, food, orders, order_details)    │
└─────────────────────────────────────────────────────┘
```

---

## 10. PROJECT DEVELOPMENT PHASES

### Phase 1: Planning & Design (Days 1-2)
- Define requirements
- Create E-R diagram
- Design database schema
- Create UI mockups

### Phase 2: Database Setup (Days 2-3)
- Create MySQL database
- Create tables with proper relationships
- Insert sample data
- Test database connections

### Phase 3: Backend Development (Days 3-5)
- Develop database connection file (db.php)
- Develop user authentication (register, login, logout)
- Develop order management functions
- Develop admin functions

### Phase 4: Frontend Development (Days 5-6)
- Design HTML pages
- Create CSS styling
- Implement client-side validation
- Add user-friendly features

### Phase 5: Integration Testing (Days 6-7)
- Test user registration and login
- Test menu browsing and ordering
- Test admin functions
- Test database operations

### Phase 6: Documentation & Deployment (Days 7-8)
- Document code and processes
- Create user manual
- Create deployment guide
- Prepare for viva/presentation

---

## 11. TECHNOLOGY JUSTIFICATION

### Why PHP (Procedural)?
- ✅ Beginner-friendly, easy to learn
- ✅ Fast development cycle
- ✅ Server-side processing
- ✅ Direct database integration
- ✅ No complex OOP concepts

### Why MySQL?
- ✅ Open-source, free
- ✅ ACID compliance
- ✅ Good for relational data
- ✅ Excellent for learning SQL
- ✅ Wide industry adoption

### Why HTML/CSS/JavaScript?
- ✅ Universal support in browsers
- ✅ No installation required
- ✅ Easy to learn and debug
- ✅ Good for front-end design
- ✅ Basic JavaScript for interactivity

### Why XAMPP?
- ✅ All-in-one package (Apache, MySQL, PHP)
- ✅ Easy installation and setup
- ✅ No configuration needed
- ✅ Portable across systems
- ✅ Perfect for local development

---

## CONCLUSION

This online food ordering system demonstrates core SDLC principles including requirements analysis, system design, database normalization, and implementation. The project is simple yet complete, suitable for second-year engineering students to understand real-world application development with practical database and web application concepts.

---

END OF SDLC DOCUMENTATION
