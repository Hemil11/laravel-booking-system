# Features Documentation (ReserveDesk)

This document explains the major capabilities of the Laravel booking system and what each feature does for end users and administrators.

---

## Booking System

The booking system powers appointment discovery, availability, and reservations.

Key functionalities:

- Service-based booking workflow that connects customers to staff and services
- Slot availability calculation based on staff working hours, service duration, and existing reservations
- Conflict detection to prevent double-booking the same time range
- Reservation grid using 30-minute steps (stored as booking slots)
- Booking lifecycle management with statuses such as `pending`, `confirmed`, `completed`, and `cancelled`
- Booking management screens for users:
  - Booking list with details and status actions
  - Booking calendar with day/week views
- Calendar UI:
  - Visual blocks for booked appointments
  - Clickable free slots (after selecting a staff member) that open the booking form with time prefilled

---

## Authentication

Authentication controls access to web pages and API endpoints.

Key functionalities:

- Web login and logout via Laravel session authentication
- User registration that automatically assigns the `customer` role
- “Remember me” support on login
- API authentication with Laravel Sanctum using Bearer tokens
- Separate public API routes for `register` and `login`, and Sanctum-protected routes for creating bookings

---

## Role System (Users, Permissions, Authorization)

The role system determines what each user can do.

Key functionalities:

- Role assignment to users (for example: `admin`, `staff`, `customer`)
- Permission-based authorization that allows fine-grained access control
- Pivot tables connect:
  - `users` to `roles` (via `user_role`)
  - `roles` to `permissions` (via `role_permission`)
- Permission checks are enforced with middleware (for example `permission:manage_users`, `permission:manage_services`, `permission:manage_bookings`)
- Application-level helpers to check permissions on the `User` model, making controller logic cleaner and more maintainable

---

## Admin Dashboard

The admin dashboard provides operational visibility for the booking business.

Key functionalities:

- “At a glance” metrics for:
  - Total users
  - Total bookings
  - Total services
  - Revenue (sum of paid invoice totals)
- Cached dashboard statistics for performance
- Quick navigation to high-frequency admin actions (such as creating bookings)

---

## Pagination and Filters

Admin and user listing screens support search, filtering, and pagination.

Key functionalities:

- Standard filter bar pattern across list pages
- Keyword search to find records by relevant fields (such as name or email)
- Status-based filtering where applicable (for example email verification status, catalog status, booking status)
- Date range filters using `date_from` and `date_to`
- Pagination for large datasets (for example `paginate(15)` / `paginate(20)`)
- Query-string persistence so filters stay applied when you change pages (`withQueryString()`)

---

## Invoice System

Invoices represent billing records for bookings, including admin management and document output.

Key functionalities:

- Invoice record linked to a booking (one-to-one style association)
- Invoice totals computed from the booked service pricing with tax logic
- Invoice status workflow:
  - `unpaid` and `paid` states
- Demo “mock payment” flow for staging and portfolio testing
  - Mock payment updates invoice status and may update booking status accordingly
- Invoice PDF generation
  - PDF download for invoices (permission-aware)

---

## Summary

ReserveDesk combines reliable scheduling logic (availability + conflict detection), role-based access control, and admin tooling (dashboard, management, invoices) into a complete booking platform.

