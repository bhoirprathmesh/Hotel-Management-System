# 🏨 Hotel Management System
A web-based hotel management system designed to streamline bookings, customer records, and room availability. Developed as part of a full-stack project to demonstrate CRUD operations using PHP and MySQL.

---

## 🚀 Project Overview  
The Hotel Management System is a responsive and user-friendly platform that helps hotel staff manage room bookings, check-in/check-out, customer records, and availability. Built with a clean front end and a robust PHP-MySQL backend, it ensures smooth operations and efficient data handling.

---

## 🧩 Features  
✅ Customer Registration & Login  
🛏️ Room Booking and Availability Management  
📅 Check-in / Check-out Tracking  
📄 View Booking History & Invoices  
🛠️ Admin Dashboard for Hotel Staff  
🔐 Secure Login System (Session-based)  
📊 Manage Rooms, Customers, and Bookings

---

## 🛠 Tech Stack

**Frontend:**
- HTML  
- CSS  (Bootstrap 5)

**Backend:**
- PHP (Core PHP)  
- MySQL (via phpMyAdmin)  

**Database:**
- phpMyAdmin / MySQL  

**Web Server:**
- XAMPP (Localhost)

---

## ⚙️ Setup Instructions

### 1. Clone the Repository
```bash
git clone https://github.com/your-username/hotel-management-system.git
cd hotel-management-system
```


### 2. Set Up the Local Server
• Install XAMPP (or any PHP server with MySQL).

• Move the project folder to htdocs (e.g., C:\xampp\htdocs\hotel-management-system).

### 3. Configure the Database
• Start Apache and MySQL from XAMPP control panel.

• Open http://localhost/phpmyadmin.

• Create a database named: hotel_db.

• Import the SQL file:

  • Go to the Import tab and upload hotel_db.sql from the project directory.

### 4. Configure Database in Code
• Open config.php or the relevant DB config file.

• Update the MySQL connection credentials if needed:

```bash
$conn = new mysqli('localhost', 'root', '', 'hotel_db');
```

### 5. Start the Application
• Visit: http://localhost/hotel-management-system/

• Use admin or user credentials to log in and explore the system.

