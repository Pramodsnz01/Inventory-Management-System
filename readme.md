# Inventory Management System

A web-based Inventory Management System built using **PHP**, **MySQL**, **HTML**, **CSS**, and **JavaScript**. This system allows administrators to manage users, products, stock, and roles with permission control.

---

## 🔧 Technologies Used

- **PHP** – Server-side scripting for database interaction, authentication, and business logic.
- **MySQL** – Database for storing users, inventory items, and permissions.
- **HTML/CSS** – Markup and styling of the user interface.
- **JavaScript** – Client-side form validation and interactive features.
- **Font Awesome** – Icons and visual enhancements.

---

## 🚀 Features

- User registration and role-based login system.
- Dashboard with stock overview and reports.
- Add, update, and delete users and inventory items.
- Form validation with JavaScript.
- Permission-based access to certain features.
- Session-based login authentication.

---

## 📁 File Structure

/inventory-management-system/
│
├── index.php # Dashboard homepage
├── login.php # Login page
├── users-add.php # Create new user form
├── database/ # All DB operations (add, delete, update, show)
│ ├── add.php
│ ├── delete.php
│ └── show.php
├── partials/ # Reusable components
│ ├── app-header-scripts.php
│ ├── app-scripts.php
│ ├── app-sidebar.php
│ ├── app-topnav.php
│ └── permissions.php
├── assets/ # CSS, JS, images
├── README.md # Project documentation
└── ...

yaml
Copy
Edit

---

## ⚙️ How to Run

1. Clone or download the project.
2. Import the SQL file into **phpMyAdmin**.
3. Update database credentials in the `database/connection.php` file.
4. Start a local server using **XAMPP**, **WAMP**, or **Laragon**.
5. Open `localhost/inventory-management-system/login.php` in your browser.

---

## 🔒 Authentication

- Uses PHP **sessions** to manage user login states.
- Only users with specific **permissions** can access certain pages (e.g., create user).

---

## ✍️ Notes

- Email addresses are validated and should be unique.
- Form input is sanitized for basic security.
- Can be extended with features like barcode scanning, export reports, or inventory logs.

---

## 🙋‍♂️ Why PHP?

While many projects use modern JavaScript frameworks like React, this project demonstrates how **PHP can handle full-stack logic efficiently** without requiring separate front-end and back-end layers. It’s lightweight, easier to deploy on shared hosting, and excellent for learning the fundamentals of server-side programming.

---

## 📩 Contact

For any queries or contributions, feel free to connect with me.