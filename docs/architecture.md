# System Architecture (Laravel Booking System)

This document explains how the Laravel booking system is structured. If you’re new to Laravel, think of it as a pipeline:
**routes → controllers → validation → business services → models (database) → views/JSON responses**.

---

## MVC Structure

### Routes (entry points)
- `routes/web.php`: routes for browser pages (Blade views), including login/logout, booking pages, and the admin UI.
- `routes/api.php`: routes for REST endpoints that return JSON.

### Controllers (request handling)
Controllers receive the request, run validation, load any required data, and call the “business logic” layer.

In this project you’ll find:
- Web controllers: booking screens, services, staff management, admin screens
- API controllers (`app/Http/Controllers/Api/`): register/login, services list, available slots, booking creation

### Models (data + relationships)
Eloquent models represent database tables and define relationships such as:
- `Booking` belongs to `User`, `Staff`, and `Service`
- `Invoice` belongs to `Booking`
- `Staff` and `Service` connect through a pivot table (`staff_service`)
- `Booking` has many `BookingSlot` records that represent reserved time-grid blocks

### Views (web UI)
HTML pages are rendered using Blade under `resources/views/`.
The admin area uses a shared layout (`resources/views/layouts/admin.blade.php`).

### Responses (API JSON)
API endpoints return JSON using a consistent envelope from `app/Http/Responses/ApiResponse.php`.

---

## Models and Relationships (Core Domain)

### Booking
Central appointment record that links:
- `user_id` → customer
- `staff_id` → staff member
- `service_id` → booked service

It also owns:
- `slots()` (many `BookingSlot` rows) used for conflict detection
- `invoice()` (one invoice for the booking)

### Staff
Represents a staff member with:
- working hours (`start_time`, `end_time`)
- active/inactive state (`is_active`)

Relationships:
- `user()` (staff profile belongs to an account)
- `services()` (many-to-many with services via `staff_service`)
- `bookings()` and `slots()` to support scheduling and calendar views

### Service
Represents the bookable service:
- `duration` and `price`
- optional `description` and `image_path`

Relationships:
- `staffs()` (many-to-many via `staff_service`)
- `bookings()` for tracking usage over time

### Invoice
Billing record linked to a booking (`booking_id` is unique).

---

## Controllers and Services

### API Controllers (JSON)
Located in `app/Http/Controllers/Api/` and typically:
1. Validate request data using `FormRequest` classes under `app/Http/Requests/Api/`
2. Use services (or model queries) to compute results
3. Return `ApiResponse::success()` or `ApiResponse::error()`

### Booking Service (business logic)
The heart of the scheduling system is:
- `app/Services/Booking/BookingService.php`

It performs:
- available slot generation (based on staff hours + service duration + existing bookings)
- conflict detection
- booking creation (including reserving time-grid slots)

### Invoice Service and Payment Service
- `app/Services/Invoice/InvoiceService.php` computes invoice totals for a booking
- `app/Services/Payment/MockPaymentService.php` implements the demo “payment” flow

---

## Folder Structure (What to Look At)

- `routes/`
  - `web.php`: web pages + admin pages
  - `api.php`: REST endpoints
- `app/Http/Controllers/`
  - `Api/`: REST controllers
  - admin controllers for dashboard/users/invoices
  - booking/services controllers for web UI
- `app/Http/Requests/`
  - `Api/`: request validation for REST endpoints
  - booking and admin request validation
- `app/Models/`
  - `Booking`, `Staff`, `Service`, `Invoice`, `User`, role/permission models
- `app/Services/`
  - `Booking/BookingService.php` for availability + booking creation
  - `Invoice/InvoiceService.php` for invoice calculation
  - `Payment/MockPaymentService.php` for demo payments
- `resources/views/`
  - `admin/` pages for the admin UI
  - `frontend/` pages for the public site and booking page

---

## Why This Structure Works

Laravel controllers stay thin (coordination only), while the business rules live in services. This keeps the system maintainable as you add new features like real payments, reminders, and multi-tenant support.

