<p align="center">
  <a href="https://github.com/abood3omar/ratteb">
    <img src="public/images/logo.png" alt="Ratteb Logo" width="120" height="120">
  </a>
</p>

<h1 align="center">Ratteb (رتّب) - Event Planning Platform</h1>

<p align="center">
  <strong>Your smart platform for organizing events, calculating costs, and booking services with ease.</strong>
</p>

<p align="center">
  <a href="https://laravel.com"><img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel"></a>
  <a href="https://microsoft.com/sql-server"><img src="https://img.shields.io/badge/SQL_Server-CC2927?style=for-the-badge&logo=microsoft-sql-server&logoColor=white" alt="SQL Server"></a>
  <a href="https://tailwindcss.com"><img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS"></a>
  <a href="https://alpinejs.dev"><img src="https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white" alt="Alpine.js"></a>
</p>

<br>

## 📋 About The Project

**Ratteb** is a sophisticated event planning system designed to bridge the gap between event service providers and customers. It solves the chaos of organizing weddings, parties, or corporate events by providing a unified **"One-Stop Shop"** experience.

The system relies on a powerful **DataBank** architecture where admins configure the core data (Providers, Services, Packages), allowing users to mix and match these services through a dynamic **Wizard** interface.

---

## 🔄 How It Works (System Workflow)

1.  **The Guest Experience:**
    * A visitor lands on the site and browses available services.
    * They enter the **Planning Wizard** to build a custom event (selecting Venue, Food, Decoration, etc.).
    * **Smart State Persistence:** If the user isn't logged in, the system **saves their draft locally**. They are redirected to Login/Register and then immediately returned to their draft without losing any data.

2.  **The Booking Process:**
    * Once confirmed, the booking is stored in **SQL Server**.
    * Real-time notifications are sent to the Administration.

3.  **Admin Control:**
    * Admins review the incoming booking requests via the **Admin Dashboard**.
    * The system allows Accepting/Rejecting bookings based on availability.
    * Admins manage the entire system structure via the **DataBank Module**.

---

## 🗄️ Database Design (ERD)

The system is built on a robust relational database schema designed for scalability and data integrity.

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
  <img src="public/images/website/databank.png" alt="Databank" width="100%">
</p>

<p align="center">
  <img src="public/images/website/plan.png" alt="Plan" width="100%">
</p>

<p align="center">
  <img src="public/images/website/my-bookings-user.png" alt="My bookings" width="100%">
</p>

<p align="center">
  <img src="public/images/website/bookings-admin.png" alt="bookings" width="100%">
</p>


---


## ✨ Key Features

### 🚀 Advanced User Features:
* **Interactive Planning Wizard:** A step-by-step guide to customize events.
* **Draft Persistence:** Uses `LocalStorage` + `Laravel Logic` to keep user selections safe across sessions.
* **Real-Time Cost Calculation:** Instant price updates as services are added/removed.
* **Responsive UI:** Mobile-first design using Tailwind CSS.

### 🛡️ Admin & Security (Back-Office):
* **Role-Based Access Control (RBAC):** dynamic permission system (Permissions, Roles, Routes protection).
* **DataBank Architecture:** A centralized module to manage:
    * **Occasion Types:** (Weddings, Graduations, Meetings...).
    * **Categories:** (Venues, Catering, Flowers...).
    * **Service Providers:** (Vendor profiles and details).
    * **Services:** (Individual items with pricing and capacity).
* **System Monitoring:** View active sessions and system health.

---

## 🛠️ Tech Stack

* **Backend:** PHP 8.x, Laravel 10.x
* **Database:** Microsoft SQL Server (SQLSRV)
* **Frontend:** Blade, Tailwind CSS, Alpine.js
* **Version Control:** Git & GitHub

---

## 👨‍💻 Developed By

**Abdalrhman Hamed** - *Full Stack Web Developer*

Connect with me:
* [![LinkedIn](https://img.shields.io/badge/LinkedIn-0077B5?style=flat&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/abdalrhman-hamed-5b929725b/)
* [![GitHub](https://img.shields.io/badge/GitHub-100000?style=flat&logo=github&logoColor=white)](https://github.com/abood3omar)
* [![Instagram](https://img.shields.io/badge/Instagram-E4405F?style=flat&logo=instagram&logoColor=white)](https://www.instagram.com/abood3omar/)

---

<p align="center">
  © 2026 Ratteb Project. All rights reserved.
</p>
