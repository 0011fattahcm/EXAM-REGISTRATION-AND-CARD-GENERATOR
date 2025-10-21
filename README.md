# Exam Registration and Card Generator (JECA)

**Exam Registration and Card Generator (JECA)** is a web-based system built with **PHP Native** and **Composer** that streamlines the management of exam participants.  
The platform allows users to register for exams through an online form, automatically generate examination cards in **Excel format**, and provides an **admin dashboard** to manage all participant data efficiently.

---

## 🧱 System Overview

This system was developed to simplify the administrative workflow of candidate registration and exam card issuance within the **Japan Education and Career Association (JECA)** environment.  
It enables administrators to register, update, and export participant data with just a few clicks, replacing manual Excel-based processes with an automated and structured solution.

---

## ⚙️ Core Features

### 👨‍🎓 User Side
- Online registration form for exam participants.  
- Input validation for personal and exam-related information.  
- Automatic generation of unique exam numbers.  
- Real-time confirmation of successful registration.

### 🧾 Admin Side
- Secure login authentication for administrators.  
- View, search, edit, and delete participant data.  
- Export participant lists or individual exam cards to **Excel**.  
- Filter participants by exam session, type, or status.  
- Activity logging for accountability and traceability.

### 📊 Exam Card Generator
- Auto-filled Excel card templates based on participant data.  
- Consistent layout and styling for JECA exam format.  
- Instant download from the dashboard.  

---

## 🧩 Technology Stack

| Layer | Technology |
|-------|-------------|
| **Language** | PHP 8+ |
| **Framework** | Native PHP (structured MVC pattern) |
| **Dependency Manager** | Composer |
| **Database** | MySQL (phpMyAdmin supported) |
| **Excel Export** | PhpSpreadsheet |
| **Frontend** | HTML5, CSS3, JavaScript, Bootstrap 5 |
| **Session Management** | PHP Native Sessions |
| **Authentication** | Email + Password-based login |
| **Environment** | Apache (XAMPP/LAMP) |

---

## 📦 Installation Guide

### Prerequisites
- PHP ≥ 8.0  
- MySQL ≥ 5.7  
- Composer installed  
- Apache server (e.g., XAMPP, LAMP, Laragon)

### Steps
1. Clone or download this repository:
   ```bash
   git clone https://github.com/yourusername/jeca-exam-registration.git
   ```
2. Install dependencies using Composer:
   ```bash
   composer install
   ```
3. Create a MySQL database (e.g., `db_exam_jeca`) and import the included SQL file:
   ```sql
   source /database/db_exam_jeca.sql
   ```
4. Configure database credentials in `config/koneksi.php`:
   ```php
   $db_host = "localhost";
   $db_user = "root";
   $db_pass = "";
   $db_name = "db_exam_jeca";
   ```
5. Start your local server and open:
   ```
   http://localhost/jeca-exam-registration/
   ```

---

## 🧠 Project Structure

```
📦 jeca-exam-registration
 ┣ 📁 assets/               # CSS, JS, images
 ┣ 📁 includes/             # Reusable functions and session handlers
 ┣ 📁 admin/                # Admin dashboard pages
 ┣ 📁 user/                 # User registration and form pages
 ┣ 📁 export/               # Excel generation scripts (PhpSpreadsheet)
 ┣ 📁 vendor/               # Composer dependencies
 ┣ 📄 index.php             # Main entry point
 ┣ 📄 composer.json         # Composer config file
 ┣ 📄 config/koneksi.php    # Database configuration
 ┣ 📄 database/db_exam_jeca.sql  # Database schema
 ┗ 📄 README.md             # Project documentation
```

---

## 🧾 Database Schema Overview

**Table: participants**
| Column | Type | Description |
|--------|------|-------------|
| `id` | INT | Primary key |
| `exam_number` | VARCHAR(50) | Unique exam ID |
| `name` | VARCHAR(100) | Participant full name |
| `birth_date` | DATE | Date of birth |
| `email` | VARCHAR(100) | Contact email |
| `phone` | VARCHAR(20) | Contact number |
| `exam_type` | VARCHAR(50) | Type of exam |
| `session` | VARCHAR(50) | Exam session |
| `registered_at` | DATETIME | Registration timestamp |

---

## 📤 Excel Export Specification

- Library: **PhpSpreadsheet**
- Output format: `.xlsx`
- Columns: Exam Number, Name, Birth Date, Exam Type, Session, Status
- File name format:  
  ```
  ExamCard_[Session]_[Date].xlsx
  ```
- Auto-formatting includes borders, alignment, and JECA header logo.

---

## 🔐 Security Features

- CSRF token for form submission.  
- Server-side validation on all inputs.  
- Session-based access restriction for admin pages.  
- Clean separation between user and admin endpoints.

---

## 🚀 Deployment Guide

For production environments:
1. Upload the project folder to your hosting root (`public_html` or `/var/www/html`).
2. Configure database credentials for the live server.
3. Ensure `vendor/` is uploaded or run `composer install` again on the server.
4. Set folder permissions for `/export` if Excel export is required.
5. Access via your domain:
   ```
   https://exam.jecaid.com/
   ```

---

## 🏷️ Keywords
`PHP` `Composer` `PhpSpreadsheet` `Exam Registration` `Excel Export` `Admin Dashboard` `JECA` `Education System`
