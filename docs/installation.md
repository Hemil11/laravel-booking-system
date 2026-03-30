# Installation Guide (Beginner-friendly)

These steps set up the Laravel booking system locally.

---

## Requirements

- PHP `8.2+`
- Composer
- Node.js `18+` and npm
- A database (SQLite for fastest setup, or MySQL/PostgreSQL)

---

## Step-by-step installation

### 1) Clone the repo

```bash
git clone <repository-url> laravel-booking-system
cd laravel-booking-system
```

### 2) Install PHP dependencies

```bash
composer install
```

### 3) Install Node dependencies

```bash
npm install
```

### 4) Set up your `.env`

```bash
# Windows
copy .env.example .env

# macOS / Linux
cp .env.example .env

php artisan key:generate
```

Edit `.env`:

- Set `APP_NAME` and `APP_URL` (example: `http://127.0.0.1:8000`)
- Choose your database:
  - **SQLite (quickest):** set `DB_CONNECTION=sqlite` and ensure `database/database.sqlite` exists
  - **MySQL / PostgreSQL:** set `DB_CONNECTION`, `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

### 5) Migrate and seed

```bash
php artisan migrate
php artisan db:seed
```

This seeds demo data including roles/permissions, sample services/staff, and demo bookings.

### 6) Build frontend assets

Recommended for first run:

```bash
npm run build
```

Optional hot reload during development:

```bash
npm run dev
```

### 7) Run the server

```bash
php artisan serve
```

Open:
`http://127.0.0.1:8000` (or your configured `APP_URL`)

---

## One-command bootstrap (optional)

```bash
composer run setup
```

You may still need to adjust your `.env` database settings before/after running it.

