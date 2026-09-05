# 📋 PharmaCare MS — Sprint Development Changelog & Work Log
**Sprint Duration:** August 31, 2026 – September 5, 2026  
**Developer / Student Schedule:** Working Hours (08:00 – 17:00) | University / Development Slots (18:00 – 21:00 & 23:00 – 02:00)  
**Project:** Pharmacy Inventory Management & Point-of-Sale (POS) System  
**Stack:** Laravel 11, MySQL, Pure Blade, Corporate Slate CSS Palette, Bootstrap Icons  

---

## 📅 Sprint Timeline & Session Logs

---

### 🟢 Session 1: Project Initialization, Database Architecture & Core CRUD
* **Date:** Wednesday, September 2, 2026
* **Time:** 22:00 – 01:00 (Night Session)
* **Milestone:** Application Foundation & Inventory Module

#### 🚀 Changes & Features Implemented:
* **Project Setup:** Initialized Laravel 11 project and installed Laravel Breeze (Blade stack).
* **Database Schema Design:** Built migrations for all 5 core tables:
  * `users` (Added enum role: `admin`, `pharmacist`, `cashier`)
  * `categories` (Drug classifications)
  * `medicines` (Drug catalog, barcodes, stock, cost/price, expiry dates, image uploads)
  * `sales` (Invoices, customer details, cashier foreign key)
  * `sale_items` (Itemized transaction lines with historical unit price snapshot)
* **Eloquent Models & Relationships:** Established all `belongsTo` and `hasMany` relationships with attribute casts.
* **RBAC Route Security:** Built and registered custom `RoleMiddleware` in `bootstrap/app.php` to restrict unauthorized access per role.
* **Design System Scaffold:** Created raw custom CSS structure inside `public/assets/css/` (`layout.css`, `dashboard.css`, `index.css`, `form.css`, `show.css`) featuring the Corporate Slate Palette (`#0f172a`, `#1e293b`).
* **Category CRUD:** Built `CategoryController` and complete Blade views (`index`, `create`, `edit`) with search filters.
* **Medicine CRUD:**
  * Implemented file upload handling to `storage/app/public/medicines/`.
  * Built automatic Barcode / SKU generation (`MED-XXXXX`) if left blank.
  * Added dynamic expiry engine badges (Safe, Near Expiry `<30 days`, Expired `≤ Today`).
* **Database Seeding:** Seeded default accounts for Admin, Pharmacist, Cashier, and initial categories.
* **Git Checkpoint:** Initial repository commit pushed to GitHub.

---

### 🟢 Session 2: Layout & Profile Integration
* **Date:** Thursday, September 3, 2026
* **Time:** 07:00 – 07:30 (Morning Pre-Work Session)
* **Milestone:** Master Layout Consistency

#### 🚀 Changes & Features Implemented:
* **Master Layout Refactoring:** Unified application layout using `@extends('layouts.pharmacy')` and `@yield('content')`.
* **Sidebar Profile Quick Link:** Added interactive profile link and logout button in the sidebar footer.
* **Layout Isolation:** Resolved Blade component conflicts by removing legacy `<x-app-layout>` tags.

---

### 🟢 Session 3: Point-of-Sale (POS) Engine & Atomic Checkout
* **Date:** Thursday, September 3, 2026
* **Time:** 19:00 – 22:00 (Evening University Session)
* **Milestone:** Retail POS Cashier Workflow

#### 🚀 Changes & Features Implemented:
* **POS Catalog & Cart UI:** Created `PosController` and 2-column cashier interface (`pos/index.blade.php`).
* **Controller Namespace Resolution:** Fixed Intelephense `P1009` namespace resolution via route cache optimization.
* **Auto-Generated Readonly Customer Code:** Implemented chronological Customer ID generation (`CUST-YYYYMMDDHHmmss`).
* **State Persistence (Cart Preservation):**
  * *Bug Resolved:* Fixed cart wiping out when filtering categories or searching.
  * *Solution:* Implemented browser `localStorage` handler (`pharmacy_pos_cart`) to persist cart data across server-side reloads.
* **Dynamic Code Retention:**
  * *Bug Resolved:* Prevented customer code regeneration during category filter clicks using `sessionStorage` (`pos_cust_code`).
* **Atomic Checkout Engine (`DB::transaction`):**
  * Built `checkout()` method in `PosController` wrapped inside `DB::beginTransaction()` and `DB::commit()`.
  * Added pessimistic row-level locking (`Medicine::lockForUpdate()`) to eliminate race conditions.
  * Added hard safety lock preventing cashier checkout of expired medicines (`isExpired()`).
  * Real-time stock decrementing (`decrement('stock_quantity')`) and automatic status change to `Low Stock`.
  * Added strict payment validation (blocking underpaid orders).
* **Git Checkpoint:** Pushed POS cashier cart and atomic transaction logic to GitHub.

---

### 🟢 Session 4: Sales History & Thermal Invoice Receipts
* **Date:** Thursday, September 3, 2026
* **Time:** 23:00 – 01:00 (Late Night Session)
* **Milestone:** Receipt Printing & Audit Log

#### 🚀 Changes & Features Implemented:
* **Sales History Module:** Built `SaleController@index` with real-time invoice/customer search and payment method indicators.
* **Printable Invoice Receipt:**
  * Created `resources/views/sales/show.blade.php` styled with Cambodia pharmacy branding.
  * Configured `@media print` CSS stylesheet to hide sidebar and navigation, printing strictly the receipt card.
* **POS Redirect Workflow:** Connected checkout submission to redirect straight to the printable invoice view.
* **Git Checkpoint:** Committed sales history and receipt print module.

---

### 🟢 Session 5: Security Hardening, UI Polish & Master Seeder
* **Date:** Friday, September 4, 2026
* **Time:** 19:00 – 21:00 & 23:00 – 02:00 (Evening & Night Session)
* **Milestone:** Security, Authentication & Production Seeding

#### 🚀 Changes & Features Implemented:
* **Profile View Refactoring:** Converted Breeze profile sub-views (`update-profile`, `update-password`, `delete-user`) into pure custom CSS matching `form.css`.
* **Enterprise Security Hardening:**
  * Disabled public self-registration (`RegisteredUserController` removed) to protect internal POS access.
  * Rebuilt `resources/views/auth/login.blade.php` with Deep Slate theme, input icons, and embedded demo account credentials.
* **Official Branding:** Integrated official `assets/images/PhamarcyLogo.png` across login, navbar, and invoice headers.
* **Master Database Seeding:**
  * Seeded **25 realistic medicines** across 5 categories with varied stock levels and expiry dates.
  * Seeded 3 pre-configured staff accounts (`admin`, `pharmacist`, `cashier`).
* **Numbered Pagination Bar:** Created custom pagination CSS with active page pill styles, query string persistence (`withQueryString()`), and result counts.

---

### 🟢 Session 6: Final Release, Media Sync & Documentation
* **Date:** Saturday, September 5, 2026
* **Time:** 09:00 – 11:30 (Morning Final Polish)
* **Milestone:** Submission Readiness & Repository Delivery

#### 🚀 Changes & Features Implemented:
* **Git Storage Tracking for Images:**
  * Adjusted `storage/app/public/.gitignore` and force-tracked `storage/app/public/medicines/` so cloned repositories load sample photos out of the box.
* **POS Grid Alignment:** Adjusted responsive grid math (`paginate(15)` / 4-5 column ratio) to eliminate uneven trailing rows on desktop screens.
* **Repository Documentation:** Published comprehensive `README.md` featuring architecture diagrams, test credentials, and demo screenshot gallery (`docs/screenshots/`).
* **Final Release:** Verified all database relationships, permissions, and background expiry scanner (`php artisan pharmacy:check-expiry`). Ready for final grading.

---

## 📊 Summary of Final Deliverables

| Module | Files Created / Modified | Status |
|---|---|:---:|
| **Authentication & RBAC** | `RoleMiddleware.php`, `login.blade.php`, `profile/` | ✅ Complete |
| **Inventory Engine** | `CategoryController`, `MedicineController`, Migrations | ✅ Complete |
| **Point of Sale (POS)** | `PosController.php`, `pos/index.blade.php`, `localStorage` | ✅ Complete |
| **Sales & Receipts** | `SaleController.php`, `sales/index.blade.php`, `sales/show.blade.php` | ✅ Complete |
| **Design System** | `layout.css`, `dashboard.css`, `index.css`, `form.css`, `show.css` | ✅ Complete |
| **Automation & Seeders** | `CheckMedicineExpiry.php`, `DatabaseSeeder.php` (25 Drugs) | ✅ Complete |