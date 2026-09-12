# Skill Heritage - A Web-Based Digital Skill Inheritance System for Online Courses

![Project Status](https://img.shields.io/badge/Status-Completed-success)
![Tech Stack](https://img.shields.io/badge/Tech_Stack-PHP%20%7C%20MySQL%20%7C%20JS-blue)
![License](https://img.shields.io/badge/License-MIT-green)

## 📖 Overview

**Skill Heritage** is a web-based digital learning platform designed to bridge the gap between learners and skilled professionals. It facilitates the sharing and learning of technical skills in fields such as programming, web development, data science, and cybersecurity. 

Similar to how traditions are passed down, Skill Heritage focuses on passing down digital and technical knowledge from experienced instructors to students in a structured, accessible, and user-friendly manner.

## ✨ Key Features

*   **User Authentication:** Secure registration and login system for students and instructors.
*   **Course Management:** Instructors can easily create, upload, edit, and manage courses and video lessons.
*   **Student Dashboard:** Students can browse courses, enroll, access learning materials, track progress, and provide feedback.
*   **Admin Panel:** Comprehensive dashboard for administrators to manage users, courses, lessons, instructors, and monitor revenue.
*   **Interactive UI:** Responsive design with a modern, intuitive interface using Bootstrap and custom CSS.
*   **Feedback System:** Students can submit feedback on courses, which is manageable via the admin panel.
*   **Secure Data Handling:** Implementation of secure authentication, input validation, and role-based access control.

## 🛠️ Tech Stack

**Frontend:**
*   HTML5, CSS3, JavaScript
*   Bootstrap (for responsive layout)
*   Font Awesome & Google Fonts (Poppins)
*   Chart.js (for Admin Dashboard analytics)

**Backend:**
*   PHP

**Database:**
*   MySQL (Managed via phpMyAdmin)

**Development Tools:**
*   Visual Studio Code
*   Git & GitHub
*   Web Browsers (Chrome, Firefox, Edge)

## 🗂️ System Modules

1.  **User Module:** Handles registration and login for all users (Students, Instructors, Admin).
2.  **Instructor Module:** Allows instructors to upload courses, manage lessons, and track student enrollments.
3.  **Student Module:** Enables students to browse courses, enroll, watch video lessons, and manage their profiles.
4.  **Admin Module:** Provides full system control, including user management, course monitoring, payment status tracking, and system maintenance.

## 🗄️ Database Structure

The database (`lms_db`) consists of several interconnected tables to ensure data integrity:
*   `admin`: Stores administrator credentials.
*   `student`: Stores student registration details.
*   `instructors`: Stores instructor profiles.
*   `course`: Stores course details (title, description, price, duration, etc.).
*   `lesson`: Stores lesson information (name, description, video links).
*   `courseorder`: Tracks student enrollments and payment statuses.
*   `feedback`: Stores student feedback and ratings.

## 🚀 Getting Started (Installation)

To run this project locally, follow these steps:

### Prerequisites
*   XAMPP, WAMP, or any local server with PHP and MySQL.
*   Web Browser.

### Installation Steps
1.  **Clone the repository:**
    ```bash
    git clone https://github.com/Divyangi08/ELearning.git
    
