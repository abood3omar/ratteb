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
  <a href="https://tailwindcss.com"><img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS"></a>
  <a href="https://alpinejs.dev"><img src="https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white" alt="Alpine.js"></a>
  <a href="https://mysql.com"><img src="https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL"></a>
</p>

<br>

## 📋 About The Project

**Ratteb** is a comprehensive web application designed to simplify the event planning process. Whether it's a wedding, graduation, or a corporate meeting, Ratteb guides users through a step-by-step wizard to choose services (Venues, Catering, Decoration, Photography) and manages the entire booking lifecycle.

The system features a robust **Admin Dashboard** with advanced security permissions (RBAC) and a flexible **DataBank** to manage service providers and categories dynamically.

---

## ✨ Key Features

### 🚀 For Users:
* **Smart Planning Wizard:** A multi-step interactive planner to build your event from scratch.
* **State Persistence:** The system remembers your selections even if you haven't logged in yet (using LocalStorage), ensuring a smooth UX.
* **Smart Authentication:** Seamlessly redirects users to login/register while preserving their booking draft.
* **Budget Calculator:** Real-time cost estimation based on selected services.
* **Responsive Design:** Fully optimized for mobile and desktop using Tailwind CSS.
* **User Dashboard:** Manage bookings, view history, and update profile settings.

### 🛡️ For Admins (Control Panel):
* **Advanced RBAC (Role-Based Access Control):** Granular control over Users, Roles, and Permissions.
* **DataBank Module:** Dynamic management of Categories, Providers, Services, and Occasion Types.
* **Booking Management:** Review, Approve, or Reject user bookings with status tracking.
* **System Architecture:** Visualization of system modules and active sessions.
* **Notification System:** Real-time alerts for new bookings and system actions.

---

## 🛠️ Technologies Used

* **Backend:** PHP (Laravel Framework).
* **Frontend:** Blade Templates, Tailwind CSS, Alpine.js (for interactivity).
* **Database:** MySQL.
* **Icons:** FontAwesome 6.
* **Version Control:** Git & GitHub.

---

## 📸 Screenshots

*(Add screenshots of your Home page, Planner Wizard, and Admin Dashboard here)*

---

## ⚙️ Installation & Setup

1.  **Clone the repository**
    ```bash
    git clone [https://github.com/abood3omar/ratteb.git](https://github.com/abood3omar/ratteb.git)
    cd ratteb
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Environment Setup**
    Copy the `.env.example` file to `.env` and configure your database credentials:
    ```bash
    cp .env.example .env
    ```

4.  **Generate App Key**
    ```bash
    php artisan key:generate
    ```

5.  **Run Migrations & Seeders**
    ```bash
    php artisan migrate --seed
    ```

6.  **Run the Application**
    ```bash
    npm run dev
    php artisan serve
    ```

---

## 👨‍💻 Developed By

**Abdalrhman Hamed** *Full Stack Web Developer*

Connect with me:
* [![LinkedIn](https://img.shields.io/badge/LinkedIn-0077B5?style=flat&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/abdalrhman-hamed-5b929725b/)
* [![GitHub](https://img.shields.io/badge/GitHub-100000?style=flat&logo=github&logoColor=white)](https://github.com/abood3omar)
* [![Instagram](https://img.shields.io/badge/Instagram-E4405F?style=flat&logo=instagram&logoColor=white)](https://www.instagram.com/abood3omar/)

---

<p align="center">
  © 2024 Ratteb Project. All rights reserved.
</p>
