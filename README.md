# ONLINE FOOD ORDERING SYSTEM - PROJECT README

## Project Information

**Project Name:** Online Food Ordering System
**Type:** Web Application (DBMS + Web Development Project)
**Level:** Second-Year Engineering Students
**Duration:** 8 Days of Development
**Technology Stack:** PHP, MySQL, HTML, CSS, JavaScript, XAMPP

---

## 📋 Project Overview

This is a **complete, working, beginner-friendly** online food ordering system that demonstrates:
- Database design and normalization (3NF)
- SDLC principles and methodology
- Web application development
- User authentication and session management
- E-R diagrams and relational model

---

## 📁 File Structure

```
DBMS Project/
│
├── food-ordering/                    [Main Project Folder]
│   ├── db.php                        [Database connection]
│   ├── style.css                     [Styling for all pages]
│   ├── database.sql                  [Database schema & sample data]
│   │
│   ├── index.php                     [Home/Menu page]
│   ├── register.php                  [User registration]
│   ├── login.php                     [User login]
│   ├── logout.php                    [User logout]
│   ├── cart.php                      [Shopping cart]
│   ├── place_order.php               [Checkout page]
│   ├── order_summary.php             [Order confirmation]
│   │
│   ├── admin.php                     [Admin login]
│   ├── admin_dashboard.php           [Admin dashboard with stats]
│   ├── add_food.php                  [Admin: Add food item]
│   ├── view_food.php                 [Admin: Manage food items]
│   ├── delete_food.php               [Admin: Delete food item]
│   ├── update_status.php             [Admin: Update order status]
│   ├── view_order_details.php        [Admin: View order details]
│   └── admin_logout.php              [Admin logout]
│
├── SDLC_DOCUMENTATION.md             [Complete SDLC documentation]
├── TESTING_GUIDE.md                  [Manual testing test cases]
├── EXECUTION_GUIDE.md                [Step-by-step setup guide]
└── README.md                         [This file]
```

## 🗄️ Database Tables

1. Users
2. Food
3. Orders
4. Order_Details

Database follows **3NF Normalization** and uses **Primary Keys** and **Foreign Keys** for maintaining relationships. :contentReference[oaicite:1]{index=1}

---

## ⚙️ Installation

### Step 1
Install XAMPP and start:

- Apache
- MySQL

### Step 2
Create a database:

```sql
food_ordering
```

### Step 3
Import:

```text
database.sql
```

### Step 4
Copy project folder into:

```text
C:\xampp\htdocs\
```

### Step 5
Open browser:

```text
http://localhost/food-ordering/
```

---

## 🔑 Admin Credentials

```text
Email: admin@foodordering.com
Password: admin123
```

### Demo User

```text
Email: john@email.com
Password: password123
```

---

## 🍽️ Sample Menu

- Margherita Pizza – ₹350
- Biryani – ₹280
- Butter Chicken – ₹320
- Samosa – ₹50
- Mango Lassi – ₹80

---

## 🎯 Learning Outcomes

- Database Design
- ER Diagrams
- SQL Queries
- Normalization (1NF, 2NF, 3NF)
- PHP Session Management
- User Authentication
- CRUD Operations
- SDLC Concepts

---

## 🔒 Security Features

- Session-Based Authentication
- Input Validation
- XSS Protection
- Foreign Key Constraints
- Access Control for Admin Pages

---

## 🔮 Future Enhancements

- Online Payment Gateway
- Food Search & Filters
- Ratings & Reviews
- Email Notifications
- User Profile Management
- Mobile Responsive Design

---

## 👨‍💻 Author

Second-Year Engineering DBMS & Web Development Project

---

## 📄 License

This project is developed for educational and learning purposes.

---

Thank You 
