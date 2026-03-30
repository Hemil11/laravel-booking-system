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

## Installation (Step-by-step)

### 1. Clone the repository

```bash
git clone <repository-url> laravel-booking-system
cd laravel-booking-system
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install Node dependencies

```bash
npm install
```

### 4. Set up your `.env` file

```bash
# Windows
copy .env.example .env

# macOS / Linux
cp .env.example .env

php artisan key:generate
```

Then edit **`.env`**:

- Set **`APP_NAME`** and **`APP_URL`** (example: `http://127.0.0.1:8000`)  
- Choose your database:
  - **SQLite (quickest):** set `DB_CONNECTION=sqlite` and ensure `database/database.sqlite` exists  
  - **MySQL / PostgreSQL:** set `DB_CONNECTION`, `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

### 5. Migrate and seed the database

```bash
php artisan migrate
php artisan db:seed
```

Seeding creates **roles**, **permissions**, **sample services**, **staff**, **linked user accounts**, and **demo bookings**.

### 6. Compile frontend assets (recommended for first run)

```bash
npm run build
```

Optional (hot reload):

```bash
npm run dev
```

### 7. Run the server

```bash
php artisan serve
```

Open **`http://127.0.0.1:8000`** (or your configured `APP_URL`).

### One-command bootstrap (optional)

Composer defines a **`setup`** script that installs PHP deps, ensures `.env`, generates a key, migrates, installs npm, and builds assets:

```bash
composer run setup
```

You still need to configure **`.env`** (especially `DB_*`) before or after, depending on your database choice.

---
## Usage

After setup, you can explore the app in two ways:

### Web app (recommended for demos)

1. Open your app in the browser (see `APP_URL`, default: `http://127.0.0.1:8000`).
2. Log in at `/login`.
3. Use:
   - `/admin` for the admin dashboard
   - `/bookings` and `/bookings/calendar` for booking management and scheduling
4. Book and manage appointments using the seeded demo roles (see “Demo credentials” below).

### REST API (recommended for integrations)

1. Authenticate via `POST /api/register` or `POST /api/login`.
2. Use the returned `data.token` as `Authorization: Bearer {token}`.
3. Call `GET /api/services`, `GET /api/available-slots`, then `POST /api/bookings`.

---
## Screenshots

Placeholders for marketing + recruiter-friendly visuals:

- Customer booking flow: `docs/screenshots/customer-booking.png`
- Booking calendar (day/week): `docs/screenshots/booking-calendar.png`
- Admin dashboard: `docs/screenshots/admin-dashboard.png`
- Staff/staff-services setup: `docs/screenshots/staff-setup.png`
- Invoice PDF preview: `docs/screenshots/invoice-pdf.png`

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

## API Documentation (Laravel Sanctum)

Base URL: `{APP_URL}/api` (for example: `http://127.0.0.1:8000/api`)  
Always send `Accept: application/json`.

### Authentication (Sanctum)

- `POST /api/register` and `POST /api/login` are public.
- Authenticated requests require a Bearer token generated via Sanctum:
  - `Authorization: Bearer {token}`
- After `register` or `login`, the API returns:
  - `data.token` (string)
  - `data.token_type` (`"Bearer"`)

For a quick start, you can `POST /api/login` with the seeded Customer: `demo@admin.com` / `password`.

### Response format (standard envelope)

Success (`2xx`):
```json
{
  "success": true,
  "message": "OK",
  "data": { }
}
```

Error (`4xx`):
```json
{
  "success": false,
  "message": "Error message",
  "errors": { }
}
```

Notes:
- Validation failures return `422` with a field-level `errors` object.
- Unauthenticated requests return `401` with `errors: null`.

### Endpoints

#### 1) Register
`POST /api/register` (public)

Request JSON:
```json
{
  "name": "Jane Customer",
  "email": "jane.customer@example.com",
  "password": "Password1!",
  "password_confirmation": "Password1!"
}
```

Success response (`201`):
```json
{
  "success": true,
  "message": "Registration successful.",
  "data": {
    "token": "YOUR_TOKEN",
    "token_type": "Bearer",
    "user": { "id": 1, "name": "Jane Customer", "email": "jane.customer@example.com" }
  }
}
```

#### 2) Login
`POST /api/login` (public)

Request JSON:
```json
{
  "email": "admin@example.com",
  "password": "password"
}
```

Success response (`200`):
```json
{
  "success": true,
  "message": "Login successful.",
  "data": {
    "token": "YOUR_TOKEN",
    "token_type": "Bearer",
    "user": { "id": 1, "name": "Admin Name", "email": "admin@example.com" }
  }
}
```

#### 3) Services list
`GET /api/services` (public)

No request body.

Success response (`200`):
```json
{
  "success": true,
  "message": "OK",
  "data": {
    "services": [
      { "id": 1, "name": "Consultation", "duration": 60, "price": 1500 }
    ]
  }
}
```

#### 4) Available slots
`GET /api/available-slots` (public)

Query parameters:
- `staff_id` (required, integer, must exist in `staffs`)
- `service_id` (required, integer, must exist in `services`)
- `date` (required, `YYYY-MM-DD`, must be today or later)

Example:
`GET /api/available-slots?staff_id=1&service_id=1&date=2026-03-27`

Success response (`200`):
```json
{
  "success": true,
  "message": "OK",
  "data": {
    "slots": [
      { "start": "09:00:00", "label": "9:00 AM" }
    ]
  }
}
```

#### 5) Create booking
`POST /api/bookings` (authenticated, Sanctum)

Headers:
- `Authorization: Bearer {token}`
- `Accept: application/json`
- `Content-Type: application/json`

Request JSON:
```json
{
  "staff_id": 1,
  "service_id": 1,
  "date": "2026-03-27",
  "time": "09:00",
  "notes": "Optional note for the booking."
}
```

Rules:
- `time` must match `H:i` (24-hour), e.g. `"09:30"`.
- `notes` is optional, `max: 2000`.
- On creation, the API sets the booking status to `pending`.

Success response (`201`):
```json
{
  "success": true,
  "message": "Booking created.",
  "data": {
    "booking": {
      "id": 123,
      "user_id": 5,
      "staff_id": 1,
      "service_id": 1,
      "date": "2026-03-27",
      "time": "09:00:00",
      "status": "pending",
      "notes": "Optional note for the booking.",
      "staff": { "id": 1, "full_name": "John Doe" },
      "service": { "id": 1, "name": "Consultation", "duration": 60 },
      "invoice": null
    }
  }
}
```

Possible errors:
- `409` if the selected slot conflicts with an existing booking.

**Postman:** import `postman/Booking-API.postman_collection.json` for ready-made requests.

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

---

## Future Roadmap (Vision, Realistic Milestones)

This project is designed as a strong starting point for a production-grade booking platform. Planned enhancements focus on payments, scheduling UX, communication, scalability, and channel expansion.

### 1) Payment integration

- Replace the current demo “mock payment” with real payments (e.g., Stripe/PayPal).
- Support payment lifecycle states (authorized, captured, refunded) and sync booking status accordingly.
- Add webhooks for reliable payment status updates.

### 2) Calendar view upgrades

- Improve the calendar UI with smoother drag-and-drop and richer slot visualization.
- Add per-service/per-staff views and better conflict highlighting.
- Support recurring appointments and bulk booking patterns (where business rules allow).

### 3) Notifications (more channels + smarter triggers)

- Expand beyond email to include SMS and/or WhatsApp for booking confirmations and reminders.
- Add configurable notification schedules (remind X hours/days before appointment).
- Improve personalization (service name, staff name, confirmation/changes history).

### 4) Multi-tenant support

- Introduce tenant isolation so multiple businesses can run in the same app:
  - tenant-aware data scoping (services, staff, bookings, invoices)
  - tenant-specific configuration (working hours, taxes, notification emails)
- Add a tenant switcher and tenant-scoped permissions for administrators.

### 5) Mobile app support

- Prepare the system for mobile clients by formalizing/expanding the REST API.
- Add push notifications for booking updates and reminders.
- Optionally introduce a mobile-friendly booking experience (mobile web now, native app later) using the same API backend.

---

This project is provided as a **demo / portfolio** codebase. Add a `LICENSE` file (e.g. MIT) when you publish your own fork.

---

<p align="center">
  <strong>ReserveDesk</strong> · Built with Laravel · Booking & scheduling for service businesses
</p>
