# 🎟️ Event Booking API (Laravel 12 + Sanctum)

A powerful **RESTful API** for managing **events** and **bookings**, built with **Laravel 12**.  
The project includes **secure authentication (Laravel Sanctum)** and **interactive API documentation** using **Swagger (l5-swagger)**.

---

## ✨ **Features**

- **Authentication & Authorization**
  - Token-based authentication with **Laravel Sanctum**.
  - Separate admin routes for event management.
  
- **Events Management**
  - CRUD operations for events.
  - Event search by title, description, or location.
  - Pagination support for large event lists.
  
- **Bookings Management**
  - Authenticated users can book events.
  - Prevents overbooking and duplicate bookings.
  - Cancel bookings easily.

- **Interactive API Documentation**
  - Fully integrated **Swagger UI** at `/api/documentation`.
  - Built-in token authorization for testing protected endpoints.

---

## 🛠 **Tech Stack**

- **Framework:** Laravel 12 (PHP 8+)
- **Authentication:** Laravel Sanctum
- **Database:** MySQL (or any Laravel-supported database)
- **Documentation:** Swagger (`l5-swagger`)
- **Other:** Pagination, Validation, Role-based middleware

---

## 🚀 **Installation**

Run the following commands step by step:

```bash
# Clone the repository
git clone https://github.com/your-username/your-repo-name.git
cd your-repo-name

# Install PHP dependencies
composer install

# Create environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Configure your database in the .env file, then run migrations
php artisan migrate

# Install Swagger (optional if not already installed)
composer require darkaonline/l5-swagger

# Generate Swagger docs
php artisan l5-swagger:generate

# Serve the application
php artisan serve
```
---
##  **📖 API Documentation**
Generate Swagger documentation:
```bash 
php artisan l5-swagger:generate
```
Open Swagger UI in your browser:
```bash 
http://127.0.0.1:8000/api/documentation
```
---
##  **🧪 Testing with Swagger**
-Open Swagger UI at /api/documentation.

-Use the POST /api/logini endpoint to obtain a Bearer token.

-Click Authorize in Swagger and paste your token.

-Test Events and Bookings endpoints directly with live responses.


