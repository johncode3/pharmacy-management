# PharmaCare - Pharmacy Management and POS System

PharmaCare is a Laravel-based pharmacy management and point-of-sale application. It manages medicine categories, inventory, expiry dates, stock levels, cashier sales, and printable receipts through a role-protected staff portal.

## Features

- Role-based access for Admin, Pharmacist, and Cashier staff.
- Inventory management for medicine categories and medicines.
- Medicine search, category filtering, pagination, stock status, expiry status, and image support.
- POS checkout with customer details, payment method, paid amount, and change calculation.
- Stock validation and pessimistic row locking during checkout to protect inventory during concurrent sales.
- Server-side validation for checkout, inventory, profiles, and authentication forms.
- Expired medicines are blocked from POS sales.
- Dashboard statistics for revenue, today's sales, low stock, and expired medicines.
- Printable sales receipts using print-specific CSS.
- Profile update, password update, logout, and password reset flows.
- Public registration is disabled; the demo staff accounts are created by the application seeder.

## Staff Access

The database seeder creates these demo accounts. The default password for each account is `123456`.

| Role | Email | Access |
| --- | --- | --- |
| Admin | `admin@pharmacy.com` | Dashboard, inventory, POS, sales, and full access |
| Pharmacist | `pharmacist@pharmacy.com` | Dashboard, categories, and medicine inventory |
| Cashier | `cashier@pharmacy.com` | Dashboard, POS checkout, and sales |

Change or remove these demo credentials before deploying the application to a real environment.

## Technology Stack

- Backend: Laravel 13
- Runtime: PHP 8.3 or newer
- Database: MySQL
- Frontend: Laravel Blade and custom CSS
- Authentication: Laravel Breeze components customized for the staff portal
- Icons: Bootstrap Icons loaded from the Bootstrap Icons CDN
- Build tools: Vite, npm, and Tailwind CSS packages included in the project

## Core Database Tables

The application-specific database schema contains five main tables:

1. `users` - Staff accounts and role attributes.
2. `categories` - Medicine classifications.
3. `medicines` - Medicine names, barcodes, prices, costs, stock, expiry dates, images, and statuses.
4. `sales` - Sale invoices, customer details, payment information, totals, and cashier ownership.
5. `sale_items` - Quantities, historical unit prices, and subtotals for each sale.

Laravel also creates framework tables for cache, queued jobs, and sessions according to the configured database setup.

## Requirements

- PHP 8.3+
- Composer
- Node.js and npm
- MySQL
- PHP extensions required by Laravel 13

## Installation

### 1. Clone the project

```bash
git clone https://github.com/johncode3/pharmacy-management.git
cd pharmacy-management
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Configure the environment

Windows PowerShell:

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

Configure the database values in `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pharmacy_management
DB_USERNAME=root
DB_PASSWORD=
```

Create the `pharmacy_management` database in MySQL before running the migrations.

### 4. Install frontend dependencies and build assets

```bash
npm install
npm run build
```

### 5. Run migrations and seed demo data

The seeder creates three staff accounts, five categories, and 25 medicines.

```bash
php artisan migrate:fresh --seed
```

Use `migrate:fresh --seed` only in a development environment because it deletes existing database tables and data.

### 6. Link public storage

```bash
php artisan storage:link
```

This makes uploaded medicine images available through the public storage path.

### 7. Start the application

```bash
php artisan serve
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000) in a browser.

For frontend development with Vite, run this in a second terminal:

```bash
npm run dev
```

## Useful Commands

```bash
# Run the test suite
php artisan test

# Check available Artisan commands
php artisan list

# Format PHP code with Laravel Pint
vendor/bin/pint
```

## Access Rules

- All dashboard and profile routes require authentication.
- Admins and Pharmacists can manage categories and medicines.
- Admins and Cashiers can access the POS and sales history.
- Expired medicines cannot be added to a completed sale.
- Public staff registration is not available.

## Project Structure

```text
app/                    Application controllers, models, requests, and middleware
database/migrations/    Database schema
database/seeders/       Demo users, categories, and medicines
public/assets/css/      Custom application stylesheets
resources/views/        Blade pages and components
routes/                 Web and authentication routes
storage/app/public/     Publicly stored medicine images
```

## Security Notes

This project is configured for local development and demonstration. Before production use:

- Replace all demo passwords.
- Set `APP_ENV=production` and `APP_DEBUG=false`.
- Configure secure database credentials and HTTPS.
- Review upload validation and filesystem permissions.
- Set up backups and a production queue, cache, and session configuration.
