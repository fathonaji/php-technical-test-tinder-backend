# PHP Tinder Backend API (Laravel 12)

This project is a technical assignment implementing a Tinder-like backend using **Laravel 12**, including:

-   People recommendation API
-   Like / Dislike system
-   Liked people list
-   Cronjob (check if a person gets more than 50 likes → send email)
-   RDB schema
-   Swagger API documentation

## Requirements

-   PHP 8.2+
-   Composer
-   Laravel 12
-   MySQL / MariaDB

## Installation

Clone repo:

`git clone https://github.com/fathonaji/php-technical-test-tinder-backend.git cd php-technical-test-tinder-backend`

Install dependencies:

`composer install`

Copy environment file:

`cp .env.example .env`

Generate key:

`php artisan key:generate`

Setup database in `.env`:

`DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tinder_app
DB_USERNAME=root
DB_PASSWORD=`

Run migration & seeder:

`php artisan migrate --seed`

Run development server:

`php artisan serve`

## API Authentication

All API requests require **`X-User-Id` header** to simulate logged-in user.

Example:

`X-User-Id: 1`

---

# API Documentation (Swagger)

Swagger UI available at:

`http://localhost:8000/api/documentation`

Regenerate documentation:

`php artisan l5-swagger:generate`

# API Endpoints

### **GET /api/people**

List recommended people (pagination, excluding already liked/disliked).

### **POST /api/people/{id}/like**

Like a person.

### **POST /api/people/{id}/dislike**

Dislike a person.

### **GET /api/people/liked**

List of people liked by the user.

Each request requires:

`X-User-Id: <integer>`

# RDB Schema

![enter image description here](https://raw.githubusercontent.com/fathonaji/php-technical-test-tinder-backend/refs/heads/main/rdb_schema.png)

# Cronjob (Like > 50 → Send Email)

A command checks whether a person has been liked by more than 50 unique users.

Run manually:

`php artisan people:check-popular`

Cron scheduler is defined in:

`routes/console.php`

Runs every 10 minutes:

`Schedule::command('people:check-popular')->everyTenMinutes();`

### Start scheduler worker:

`php artisan schedule:work`

### Email Output

Email is sent using Laravel Mail system.  
By default, mailer uses **log** mode:

`MAIL_MAILER=log`

Email content appears in:

`storage/logs/laravel.log`

---

# Tech Stack

-   Laravel 12
-   MySQL
-   L5 Swagger
-   Laravel Mail
-   Laravel Scheduler
-   REST API Architecture

# Development Notes

-   This project uses header-based simulation login (`X-User-Id`) for assignment simplicity
-   Recommendation logic excludes already interacted people.
-   Email alert triggers only once per person (using `like_alert_sent_at`).
-   Location field currently stores plain text. For real-world implementation, it can be improved by storing `latitude` and `longitude` fields to enable geolocation filtering (distance-based recommendations).
-   In a real-world application, **the `people` table would represent actual application users**.
-   Future improvement: Add **email**, **password**, and authentication (Laravel Sanctum / JWT) so `people` can log in as real users.
