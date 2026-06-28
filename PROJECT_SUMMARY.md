# 📚 LearnCore LMS — Project Summary

LearnCore is a comprehensive, production-ready Learning Management System (LMS) designed for academic institutions. It provides a secure, role-based platform for managing academic structures, course content, student progress, assessments, and certifications.

---

## 🛠️ Technology Stack

| Layer | Technologies |
| :--- | :--- |
| **Frontend** | HTML5, Blade, Tailwind CSS, Alpine.js, Vite |
| **Backend** | PHP 8.2+, Laravel 12, Livewire v3, Filament PHP v3 |
| **Database** | PostgreSQL v17 (hosted on Supabase with PgBouncer connection pooling) |
| **Infrastructure** | Docker, Nginx, PHP-FPM, Supervisord, Render Cloud, GitHub |
| **Monitoring** | Spatie RBAC, Telegram Exception Notification Bot |

---

## 🧩 Core Modules & Features

### 1. User & Access Control (RBAC)
* Spatie Laravel Permission implementation.
* 4 defined roles:
  * **Super Admin / Admin:** Complete control over setting configurations, users, and resources.
  * **Teacher:** Manage assigned course content, quizzes, exams, and grade submissions.
  * **Student:** Access dashboard, complete lessons, view progress, and download certificates.

### 2. Academic Structure
* Hierarchy-based organization: **Faculties ➔ Departments ➔ Classrooms**.
* Semester and Academic Year mapping to classrooms.
* Teacher schedule assignments for courses, classrooms, and sessions.

### 3. Course & Content Delivery
* Cataloging of **Course Categories** and **Courses**.
* Course lessons structured by **Chapters ➔ Lessons**.
* Multi-format content uploads: **Documents (PDF), Videos (MP4/Streams), Assignments, and Resources**.
* Student progress tracking with visual progress bars.

### 4. Assessments, Exams & Grading
* Centralized **Question Bank** supporting various question types and options.
* **Quizzes & Exams** created by teachers and assigned to Classrooms/Students.
* Online **Assignment Submissions** and grading logs.
* Custom **Certificates** generation upon successful completion of curriculum.

### 5. Automated Monitoring (Telegram)
* Exception notification service that sends error logging and failed queue notifications directly to a Telegram group chat via API bot for real-time diagnostics.

---

## 🌐 Database Connection Configuration
The system uses **Supabase** for database hosting, utilizing PgBouncer for transaction-mode and session-mode connection pooling over IPv4 networks.

```env
DB_CONNECTION=pgsql
DB_HOST=aws-1-ap-southeast-1.pooler.supabase.com
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres.ikgcamoponkwwgklvsbg
DB_PASSWORD="your_supabase_password"
DB_SSLMODE=require
```

---

## 🔑 Default Test Accounts
All seeded accounts use the default password: **`123`**

* **Super Admin:** `test@example.com`
* **Teacher Example:** `alice.smith@example.com`
* **Student Example:** `james.wilson@example.com`

---

## 🚀 Deployed URL
* **Production Link:** [https://learcore.onrender.com](https://learcore.onrender.com)
