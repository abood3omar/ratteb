<p align="center">
  <a href="https://github.com/abood3omar/ratteb">
    <img src="public/images/logo.png" alt="Ratteb Logo" width="120" height="120">
  </a>
</p>

<h1 align="center">Ratteb (رتّب) - Enterprise Event Planning System</h1>

<p align="center">
  <strong>A sophisticated SaaS platform for organizing events, utilizing complex state management and dynamic pricing engines.</strong>
</p>

<p align="center">
  <a href="https://laravel.com"><img src="https://img.shields.io/badge/Backend-Laravel_10-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel"></a>
  <a href="https://microsoft.com/sql-server"><img src="https://img.shields.io/badge/Database-SQL_Server-CC2927?style=for-the-badge&logo=microsoft-sql-server&logoColor=white" alt="SQL Server"></a>
  <a href="https://tailwindcss.com"><img src="https://img.shields.io/badge/Frontend-Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS"></a>
  <a href="https://alpinejs.dev"><img src="https://img.shields.io/badge/Interactivity-Alpine.js-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white" alt="Alpine.js"></a>
</p>

<br>

## 📋 Architectural Overview

**Ratteb** is not just a booking site; it is a **multi-tenant capable event planning system** designed to solve the logistical chaos of weddings and corporate events. The project challenges standard CRUD operations by introducing a **"Wizard-Driven"** UX and a **"DataBank"** backend architecture.

### 🧠 Core Engineering Challenges Solved:

1.  **Smart State Persistence (The "Guest" Problem):**
    * **Challenge:** Users often build packages before logging in.
    * **Solution:** Implemented a hybrid storage mechanism (LocalStorage + Session) that preserves the "Draft Event" and seamlessly migrates it to the database once the user authenticates/registers.
2.  **Dynamic Pricing Engine:**
    * **Challenge:** Prices change based on quantity, dates, and package types instantly.
    * **Solution:** Built a reactive frontend using **Alpine.js** communicating with a Laravel backend service to recalculate totals in real-time without page reloads.

---

## 🔄 System Workflow

1.  **The Planning Wizard:**
    * A multi-step guided interface allowing users to mix and match venues, catering, and services.
    * Logic ensures compatibility between selected services (e.g., checking venue capacity vs. guest count).
2.  **The Booking Core:**
    * Confirmed bookings utilize **SQL Server Transactions** to ensure data integrity across the `Bookings`, `Invoices`, and `Schedules` tables.
3.  **Admin DataBank:**
    * A centralized module allowing generic control over all system entities (Providers, Services, Attributes) without code changes.

---

## 🗄️ Database Architecture (ERD)

Designed a normalized relational schema optimized for **SQL Server**, handling complex relationships between service providers and dynamic user packages.

<p align="center">
  <img src="public/images/erd/system.png" alt="System Entity Relationship Diagram (ERD)" width="100%">
</p>

<p align="center">
  <img src="public/images/erd/security.png" alt="Security Entity Relationship Diagram (ERD)" width="100%">
</p>

---

## 📸 System Gallery

<p align="center">
  <img src="public/images/website/home.png" alt="Home" width="100%">
</p>

<p align="center">
  <img src="public/images/website/plan.png" alt="Planning Wizard" width="100%">
</p>

<p align="center">
  <img src="public/images/website/bookings-admin.png" alt="Admin Dashboard" width="100%">
</p>

---

## ✨ Key Technical Features

### 🚀 Backend & Logic:
* **Role-Based Access Control (RBAC):** Custom middleware to manage granular permissions for Admins, Vendors, and Users.
* **DataBank Module:** A highly flexible architecture allowing the admin to define new service types dynamically.
* **SQL Server Integration:** Leveraged T-SQL features for reporting and complex data retrieval.

### 🛡️ User Experience (UX):
* **Interactive Wizard:** Step-by-step event builder.
* **Real-Time Validation:** Instant feedback on form inputs and availability.
* **Draft persistence:** "Build now, Login later" functionality.

---

## 🛠️ Tech Stack

* **Backend Framework:** Laravel 10.x (PHP 8.2)
* **Database:** Microsoft SQL Server (SQLSRV)
* **Frontend:** Blade Templates, Tailwind CSS
* **JavaScript:** Alpine.js (for reactive components)

---

## 👨‍💻 Developed By

**Abdalrhman Hamed** - *Software Engineer & Full Stack Developer*

Connect with me:
* [![LinkedIn](https://img.shields.io/badge/LinkedIn-0077B5?style=flat&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/abdalrhman-hamed-5b929725b/)
* [![GitHub](https://img.shields.io/badge/GitHub-100000?style=flat&logo=github&logoColor=white)](https://github.com/abood3omar)
