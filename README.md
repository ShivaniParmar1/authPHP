# PHP Authentication System

This project is a basic user authentication system built with core PHP. It includes registration, login, and user management features.

## ✅ Features

- User Registration & Login
- API-based Authentication (using cURL)
- Session-based Dashboard
- Basic User Edit & Delete
- Simple Logout Functionality


## 📁 Project Structure

| File / Folder       | Description                            |
|---------------------|----------------------------------------|
| `register.php`      | User registration form (UI)            |
| `auth_register.php` | Processes registration requests        |
| `login.php`         | User login form (UI)                   |
| `auth_login.php`    | Processes login requests               |
| `dashboard.php`     | Protected user dashboard (requires login) |
| `logout.php`        | User logout script                     |
| `api/`              | API endpoints for authentication and user actions |
| `config/`           | Configuration files (e.g., DB, API settings) |

---

## ⚠️ Notes

- API endpoint URLs are currently **hardcoded for `localhost`** — update them for production.
- **This project is intended for learning and demonstration purposes.**
  
For production use, please add:
- Password hashing (`password_hash()`, `password_verify()`)
- Proper input validation & sanitization
- HTTPS and secure session management

---
