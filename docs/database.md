# Database Structure (Laravel Booking System)

This document summarizes the main database tables used by the booking system. Field lists are based on the project migrations.

---

## `users`

### Fields

- `id` (PK)
- `name` (string)
- `email` (string, unique)
- `email_verified_at` (timestamp, nullable)
- `password` (string)
- `remember_token` (string, nullable)
- `avatar_path` (string(500), nullable)
- `created_at`, `updated_at`

### Relationships

- Many-to-many with `roles` through `user_role`
- One-to-one with `staff` (`staff.user_id` references `users.id`)
- One-to-many with `bookings` (`bookings.user_id` references `users.id`)
- Sanctum uses `personal_access_tokens` (not defined here) to store API tokens for authenticated users

### Purpose

Stores application accounts for customers, staff, and administrators. Role and permission assignments determine what each user can manage and which parts of the system they can access.

---

## `roles`

### Fields

- `id` (PK)
- `name` (string(50), unique)
- `guard_name` (string(50), default `web`)
- `created_at`, `updated_at`

### Relationships

- Many-to-many with `users` through `user_role`
- Many-to-many with `permissions` through `role_permission` (pivot table)

### Purpose

Groups permissions into named roles (e.g., Admin, Staff, Customer). Authorization checks in the app use these roles to decide what actions are allowed.

---

## `services`

### Fields

- `id` (PK)
- `name` (string(120), unique)
- `duration` (unsigned small integer, default `30`) - duration in minutes
- `price` (decimal(10,2), default `0`)
- `description` (text, nullable)
- `image_path` (string(500), nullable)
- `deleted_at` (soft delete)
- `created_at`, `updated_at`

### Relationships

- Many-to-many with `staff` through `staff_service` (pivot stores staff/service availability and pricing overrides)
- One-to-many with `bookings` (`bookings.service_id` references `services.id`)

### Purpose

Defines what customers can book. Service duration and pricing are used to compute available slots and invoice totals.

---

## `bookings`

### Fields

- `id` (PK)
- `user_id` (FK -> `users.id`)
- `staff_id` (FK -> `staffs.id`)
- `service_id` (FK -> `services.id`)
- `date` (date)
- `time` (time, stored as `HH:MM:SS`)
- `status` (string(30), default `pending`)
- `cancelled_at` (datetime, nullable)
- `notes` (text, nullable)
- `created_at`, `updated_at`

Indexes:
- composite indexes include combinations like `(staff_id, date)`, `(user_id, date)`, and `(status, date)`

### Relationships

- Belongs to `user` (`bookings.user_id`)
- Belongs to `staff` (`bookings.staff_id`)
- Belongs to `service` (`bookings.service_id`)
- Has many `booking_slots` (grid reservations tied to the booking; table name: `booking_slots`)
- Has one `invoice` (unique `invoices.booking_id`)

### Purpose

Central record of an appointment reservation. Booking slots are reserved to prevent conflicts, and the booking lifecycle is tracked using `status` (e.g., `pending`, `confirmed`, `completed`, `cancelled`).

---

## `invoices`

### Fields

- `id` (PK)
- `booking_id` (FK -> `bookings.id`, unique)
- `amount` (decimal(10,2))
- `tax` (decimal(10,2), default `0`)
- `total` (decimal(10,2))
- `status` (string(20), default `unpaid`)
- `created_at`, `updated_at`

Indexes:
- includes index on `status` and `created_at` (composite index)

### Relationships

- Belongs to `booking` (`invoices.booking_id`)
- In the application, payment flow updates:
  - invoice `status` (e.g., unpaid -> paid)
  - booking `status` (e.g., pending -> confirmed)

### Purpose

Represents the payment document for a booking. For confirmed appointments, the system can generate invoice totals and supports a demo “mock payment” flow and PDF download.

---

## Notes on supporting tables (referenced by relationships)

The five tables above are the main entities. The app also relies on related tables to implement scheduling and authorization:

- `user_role` (pivot for `users` <-> `roles`)
- `staffs` (staff members and working hours)
- `staff_service` (pivot for `staffs` <-> `services`, including availability/pricing overrides)
- `booking_slots` (time-grid reservations that prevent conflicts)
- `personal_access_tokens` (Sanctum token storage)

