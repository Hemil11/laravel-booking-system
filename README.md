# ReserveDesk

**ReserveDesk** is the demo product name for this repository—a production-style **appointment booking** platform for service businesses. Customers browse services, pick staff, and reserve time on a **30-minute grid** with conflict detection. Operators manage services, staff, bookings, **invoices**, and **reports** through a role-based admin experience, with an optional **REST API** for mobile or SPA clients.

**Branding:** The app title in the UI, notification emails, and PDFs comes from **`APP_NAME`** in `.env`. The demo uses `APP_NAME="ReserveDesk"` (see `.env.example`). Change it to match your company or white-label deployment.

---

## Features

### Customer & public site

- **Marketing pages** — Home, service catalog, service detail, contact form  
- **Book appointment** — Authenticated booking flow with live **available-slot** loading (staff, service, date)  
- **My bookings** — List, detail, confirm, cancel (within policy rules)

### Scheduling & operations

- **Booking calendar** — **Day** and **week** views, booked blocks with overlap handling, **clickable free slots** when a staff filter is selected (opens new booking with date/time prefilled)  
- **List view** — Search, filters, bulk actions (cancel / status) for authorized users  
- **Statuses** — `pending`, `confirmed`, `completed`, `cancelled` with guarded transitions  
- **Invoices** — Linked to confirmed bookings; **mock payment** flow for demos  
- **PDF invoices** — Download via Dompdf (service, customer, line items); permission-aware

### Administration

- **Dashboard** — User, booking, and service counts; paid revenue total  
- **Reports** — Booking trends (daily / weekly) and revenue breakdowns; top services  
- **User management** — CRUD and bulk actions (`manage_users`)  
- **Services & staff** — CRUD, archiving, staff–service assignments, working hours  
- **Invoice list** — Admin index with bulk actions (`manage_bookings`)

### Platform & integrations

- **Roles & permissions** — Admin, staff, and customer roles with granular permissions  
- **Email notifications** — Booking created and status changes (configure `MAIL_*`; optional `BOOKING_ALERT_EMAILS` for staff inboxes)  
- **REST API** — Register, login (Sanctum), services list, available slots, create booking  
- **Rate limiting** — Auth, payment, and PDF routes throttled where configured  
- **Performance** — Cached public API services list, admin dashboard stats, reports payload, and booking form dropdowns; selective column queries; composite index on invoices for revenue-style queries

---

## Tech stack

| Layer | Technology |
|--------|------------|
| **Runtime** | PHP **8.2+** |
| **Framework** | **Laravel 12** |
| **API auth** | **Laravel Sanctum** 4.x |
| **PDF** | **barryvdh/laravel-dompdf** 3.x (Dompdf) |
| **Database** | **SQLite** (default in `.env.example`), or MySQL / MariaDB / PostgreSQL via Laravel |
| **Frontend** | **Blade**, **Vite 5**, **Tailwind CSS 4** |
| **Quality** | Laravel **Pint**, **PHPUnit** 11 |

---

## Requirements

- PHP **8.2+** with common Laravel extensions (`openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath` as needed)  
- [Composer](https://getcomposer.org/)  
- [Node.js](https://nodejs.org/) **18+** and npm (for Vite)  
- A database (SQLite file or a MySQL/MariaDB/PostgreSQL server)

---

## Setup

### 1. Clone and install dependencies

```bash
git clone <repository-url> laravel-booking-system
cd laravel-booking-system
composer install
npm install
```

### 2. Environment

```bash
# Windows
copy .env.example .env

# macOS / Linux
cp .env.example .env

php artisan key:generate
```

Edit **`.env`**:

- Set **`APP_NAME`** and **`APP_URL`** to match your local URL (e.g. `http://127.0.0.1:8000`).  
- **Database** — either:
  - **SQLite:** `DB_CONNECTION=sqlite` and ensure `database/database.sqlite` exists (`type nul > database\database.sqlite` on Windows, or `touch database/database.sqlite` on Unix), or  
  - **MySQL / etc.:** set `DB_CONNECTION`, `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.

### 3. Database

```bash
php artisan migrate
php artisan db:seed
```

Seeding creates **roles**, **permissions**, **sample services**, **staff**, **linked user accounts**, and **demo bookings**.

### 4. Frontend assets

```bash
npm run build
```

For local development with hot reload:

```bash
npm run dev
```

### 5. Run the app

```bash
php artisan serve
```

Open **`http://127.0.0.1:8000`** (or your `APP_URL`).

### One-command bootstrap (optional)

Composer defines a **`setup`** script that installs PHP deps, ensures `.env`, generates a key, migrates, installs npm, and builds assets:

```bash
composer run setup
```

You still need to configure **`.env`** (especially `DB_*`) before or after, depending on your database choice.

---

## Demo credentials

After **`php artisan db:seed`**, these accounts exist (**all use the same password**):

| Role | Email | Password | Notes |
|------|--------|----------|--------|
| **Administrator** | `admin@admin.com` | `password` | Full admin: users, reports, dashboard, services, staff, bookings, invoices |
| **Staff** | `staff@admin.com` | `password` | **`manage_bookings`**: invoices, bookings, calendar; has a **Staff** profile for scheduling demos; service/staff **indexes** are view-only (editing requires `manage_services` / `manage_staff`) |
| **Customer** | `demo@admin.com` | `password` | Bookings and invoices for that user only |

> **Security:** These credentials are for **local and staging demos only**. Change or remove them before any public deployment.

**Web login:** `/login`  
**Admin dashboard:** `/admin` (requires `manage_users`)  
**Bookings / calendar:** `/bookings`, `/bookings/calendar`

---

## API overview

Base URL: `{APP_URL}/api` — send **`Accept: application/json`**.

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| `POST` | `/api/register` | — | Register; returns Bearer token + user |
| `POST` | `/api/login` | — | Login; returns Bearer token + user |
| `GET` | `/api/services` | — | List services (cached payload) |
| `GET` | `/api/available-slots` | — | Query: `staff_id`, `service_id`, `date` (`Y-m-d`) |
| `POST` | `/api/bookings` | **Bearer token** | Create booking (`staff_id`, `service_id`, `date`, `time`, optional `notes`) |
| `POST` | `/api/invoices/{invoice}/mock-payment` | **Bearer token** | Demo payment (`result`: `success` or `failure`) |

Success responses use a consistent envelope: `success`, `message`, and `data`.

**Postman:** import **`postman/Booking-API.postman_collection.json`** for ready-made requests.

---

## Email (optional)

- Set **`MAIL_MAILER`** (e.g. `smtp`) and related **`MAIL_*`** variables in `.env` for real delivery.  
- With **`MAIL_MAILER=log`**, messages are written to the log only.  
- **`BOOKING_ALERT_EMAILS`** (comma-separated) receives a copy when a **new booking** is created (see `config/booking.php`).

---

## Project structure (high level)

```
app/
├── Http/Controllers/      # Web + Api/*
├── Models/
├── Notifications/         # Booking emails
├── Policies/
├── Services/Booking/        # Availability, conflicts, slots
├── Services/Invoice/
└── Support/                 # e.g. PerformanceCache keys

database/migrations/
database/seeders/

resources/views/           # Blade + components
routes/web.php
routes/api.php
```

---

## Scripts

| Command | Purpose |
|---------|---------|
| `composer run dev` | Concurrent `artisan serve`, queue worker, Pail, and `npm run dev` |
| `composer run test` | Clear config cache and run PHPUnit |
| `php artisan test` | Run tests |

---

## License

This project is provided as a **demo / portfolio** codebase. Add a `LICENSE` file (e.g. MIT) when you publish your own fork.

---

<p align="center">
  <strong>ReserveDesk</strong> · Built with Laravel · Booking & scheduling for service businesses
</p>
