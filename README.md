# Laravel E-come

## Short description
Laravel commerce application for browsing travel packages, creating travel requests/bookings, managing users, and taking payments.

## Stack
- **Backend:** Laravel (PHP)
- **Frontend:** Blade templates + Vite + CSS/JS assets
- **Database:** MySQL (or any Laravel-supported driver)
- **Payment:** Integrated payment flow (see app payment-related models/controllers)

## Features

## Database
This project uses a relational database managed by Laravel migrations.

### Supported databases
MySQL/MariaDB is the most common (configure via `.env`). Laravel also supports other drivers (PostgreSQL, SQLite, SQL Server) if you adjust `DB_CONNECTION`.

### Create database
When using XAMPP/MySQL:
- Create a database in phpMyAdmin.
- Set `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in `.env`.

### Run migrations
```bash
php artisan migrate --force
```
- User authentication (member/admin)
- Travel packages: view/search and details
- Travel requests / bookings management
- Admin dashboard for managing packages and requests
- Payment handling for bookings
- API endpoints (if configured in `routes/api.php` / routes/web as applicable)

## Installation (Production/Local)
### 1) Prerequisites
Install:
- PHP 8.2+
- Composer
- Node.js + npm

### 2) Install dependencies
```bash
composer install
npm install
```

### 3) Environment configuration
```bash
copy .env.example .env
```
Update `.env` values (especially `DB_*`, `APP_URL`, mail/queue if used).

### 4) App key + migrate
```bash
php artisan key:generate
php artisan migrate --force
```

### 5) Build assets
```bash
npm run build
```

## XAMPP Setup
1. Install **XAMPP** (Apache + MySQL).
2. Create a database and set:
   - `DB_DATABASE`
   - `DB_USERNAME`
   - `DB_PASSWORD`
   in `.env`.
3. Put the project in your XAMPP `htdocs` folder (or set appropriate vhost).
4. Configure `APP_URL` in `.env` to match your local URL, then run:
   ```bash
   php artisan key:generate
   php artisan migrate --force
   ```
5. Start Apache from XAMPP.

## Demo account
> Add real demo credentials based on your seeding/admin-creation logic.

- Admin: `admin@horizon.com` / `123456789`
- Member: `alaabousak44@gmail.com` / `98271585`

(If you use seeders, run them and update these values to match your seeded users.)

## Payment
- Booking/payment flow is implemented in the application.
- Check the payment-related model/controller:
  - `app/Models/Payment.php`
  - `app/Http/Controllers/*` (payment handling routes as implemented)

## API
- API routes (if present) are defined in the routes folder.
- Inspect:
  - `routes/web.php`
  - `routes/console.php`
  - and any `routes/api.php` (if exists)

## Notes
- Do **not** commit `.env`.
- Ensure storage is linked if needed:
  ```bash
  php artisan storage:link
  ```
- If you change assets, rebuild with:
  ```bash
  npm run build
  ```

