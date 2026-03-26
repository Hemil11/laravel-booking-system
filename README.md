# Laravel Booking System

A full-stack **appointment booking** application built with Laravel. It supports **services**, **staff**, **time-slot availability** with conflict prevention, **role-based access** (admin, staff, customer), a **web UI** for management and bookings, an **admin dashboard**, and a **token-based REST API** for mobile or SPA clients.

---

## Project overview

This project models a typical service business: staff offer specific services with durations and pricing; customers book time windows that respect staff working hours, service length, and existing appointments. Core booking rules live in a dedicated **service layer** (`BookingService`), keeping controllers thin and the API predictable.

**Highlights for reviewers**

- Clear separation of **domain logic** vs. HTTP layer  
- **REST API** with Laravel Sanctum, Form Requests, and a consistent JSON envelope  
- **Seeded demo data** for quick local evaluation  
- **Postman collection** included for API exploration  

---

## Features

| Area | Capability |
|------|------------|
| **Bookings** | Create, view, and list bookings; statuses include `pending`, `confirmed`, `cancelled` |
| **Availability** | Fetch available start times for a staff member, service, and date (30-minute grid aligned with business rules) |
| **Services & staff** | CRUD for services and staff; staff–service pivot with optional price overrides |
| **Authentication** | Session-based login for web; API register/login with personal access tokens |
| **Roles** | Admin, staff, and customer roles (many-to-many on users) |
| **Admin dashboard** | Aggregates total users, bookings, services, and today’s bookings (admin-only) |
| **API** | Register, login, list services, available slots, create booking (Bearer token) |

---

## Tech stack

| Layer | Technology |
|--------|------------|
| Runtime | PHP **8.2+** |
| Framework | **Laravel 12** |
| API auth | **Laravel Sanctum** |
| Database | MySQL / MariaDB / SQLite (via Laravel config) |
| Frontend assets | **Vite**, **Tailwind CSS 4** (welcome / tooling) |
| Dev tooling | Laravel Pint, PHPUnit, Sail (optional) |

---

## Installation

### Prerequisites

- PHP **8.2+** with extensions Laravel expects (`openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath` as needed)  
- [Composer](https://getcomposer.org/)  
- Node.js **18+** and npm (for Vite assets, if you use them)  
- A database (e.g. MySQL on XAMPP, or SQLite for quick setup)

### Steps

1. **Clone the repository** and enter the project directory.

2. **Install PHP dependencies**

   ```bash
   composer install
   ```

3. **Environment**

   ```bash
   copy .env.example .env   # Windows
   # cp .env.example .env     # macOS / Linux
   php artisan key:generate
   ```

   Configure `.env`: `APP_URL`, `DB_*` (or `DB_CONNECTION=sqlite` and create `database/database.sqlite`).

4. **Migrate (and optionally seed)**

   ```bash
   php artisan migrate
   php artisan db:seed
   ```

   The seeder creates roles, sample services, staff, customers, and bookings. Default **admin** user (if seeded): `admin@example.com` / `password`.

5. **Sanctum** — personal access tokens table is included in migrations; no extra step if migrations ran successfully.

6. **Run the application**

   ```bash
   php artisan serve
   ```

   Visit `http://127.0.0.1:8000`. Log in via `/login` to use bookings and (as admin) `/admin`.

7. **Optional — front-end build**

   ```bash
   npm install
   npm run dev
   ```

---

## API endpoints

Base URL: `{APP_URL}/api` (e.g. `http://127.0.0.1:8000/api`).

Send `Accept: application/json` on all requests. For JSON bodies, use `Content-Type: application/json`.

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| `POST` | `/api/register` | — | Register user; returns Bearer token + user |
| `POST` | `/api/login` | — | Login; returns Bearer token + user |
| `GET` | `/api/services` | — | List services |
| `GET` | `/api/available-slots` | — | Query: `staff_id`, `service_id`, `date` (`Y-m-d`) |
| `POST` | `/api/bookings` | **Bearer token** | Create booking (`staff_id`, `service_id`, `date`, `time`, optional `status`, `notes`) |

**Response shape (typical success)**

```json
{
  "success": true,
  "message": "OK",
  "data": { }
}
```

Validation errors return `success: false`, `message`, and `errors` keyed by field.

**Postman:** import `postman/Booking-API.postman_collection.json` for ready-made requests, headers, and example bodies.

---

## Folder structure

Relevant parts of the application (simplified):

```
app/
├── Exceptions/              # e.g. BookingConflictException
├── Http/
│   ├── Controllers/         # Web + Api/* controllers
│   ├── Middleware/          # e.g. EnsureUserIsAdmin
│   ├── Requests/            # Form requests (web + Api/*)
│   └── Responses/           # ApiResponse helper for JSON envelope
├── Models/                  # User, Role, Service, Staff, Booking, BookingSlot, …
├── Providers/
└── Services/Booking/        # BookingService — availability & booking rules

database/
├── factories/
├── migrations/
└── seeders/

resources/views/             # Blade layouts, services, staff, bookings, admin

routes/
├── api.php                  # Sanctum API
└── web.php                  # Web + session auth

postman/                     # Postman collection for the API
```

Tests and tooling live under `tests/`, `phpunit.xml`, Vite config at project root.

---

## Screenshots

Add your own captures to show the product in portfolios or README previews. Suggested filenames (create a folder such as `docs/screenshots/`):

| Screenshot | Suggested file | What to show |
|------------|----------------|--------------|
| Landing | `docs/screenshots/01-welcome.png` | Welcome / landing page |
| Admin dashboard | `docs/screenshots/02-admin-dashboard.png` | Stats cards (`/admin`) |
| Booking flow | `docs/screenshots/03-booking-create.png` | New booking form |
| API (optional) | `docs/screenshots/04-postman.png` | Postman or HTTP client hitting `/api` |

**Markdown placeholders** (uncomment paths after you add images):

```markdown
<!-- ![Welcome](docs/screenshots/01-welcome.png) -->
<!-- ![Admin dashboard](docs/screenshots/02-admin-dashboard.png) -->
```

---

## License

Specify your license in a `LICENSE` file at the repository root (e.g. MIT) when you publish.

---

<p align="center">
  Built with Laravel · Booking system demo / portfolio piece
</p>
