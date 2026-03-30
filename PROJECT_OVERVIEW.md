# Project Overview: ReserveDesk

ReserveDesk is a Laravel-based appointment booking system for service businesses. It helps customers browse services, select a staff member, and reserve time slots with automatic conflict detection. The platform also provides a role-based admin experience for managing services, staff, bookings, and invoices, with optional REST API support for integrations.

## What the System Does

ReserveDesk supports an end-to-end booking workflow:

- Service discovery: customers can view a catalog of services and their details (duration and pricing).
- Staff scheduling: the system calculates available time slots based on staff working hours and existing bookings.
- Booking creation: customers (or API clients) create bookings for a specific staff member, service, date, and time.
- Conflict detection: overlapping reservations are blocked to prevent double-booking.
- Booking lifecycle: bookings move through statuses such as `pending`, `confirmed`, `completed`, and `cancelled`, with guarded transitions.
- Invoicing: confirmed bookings can generate invoices, including PDF download and a demo “mock payment” flow.
- Notifications: booking events trigger email notifications to relevant parties (configurable).

## Target Users

### Administrator

The administrator manages the full system configuration and operational data:

- User management (create, edit, permissions)
- Services and staff management (including assignments and archiving)
- Booking and invoice management
- Analytics and reporting through the dashboard

### Staff

The staff role focuses on scheduling and operational visibility:

- View and manage bookings/invoices they are responsible for (based on permissions)
- Provide staff availability via working hours settings
- Support appointment scheduling workflows for demos and operations

### Customer

The customer role uses the system to book and track appointments:

- Browse available services
- Select a staff member and check available slots for a chosen date
- Create and manage their own bookings
- View invoice details related to their appointments

## Core Modules

### 1) Booking System

The booking system is responsible for availability, booking creation, and booking state management:

- Slot generation based on a fixed scheduling grid (30-minute increments)
- Availability queries that consider:
  - staff working hours and active/inactive state
  - service duration requirements
  - already-booked slot occupancy
- Booking creation that reserves the underlying time grid and prevents conflicts
- Booking status handling:
  - `pending` for newly created bookings
  - `confirmed` / `completed` / `cancelled` as the appointment progresses

### 2) Services

The services module powers the service catalog and booking parameters:

- Service catalog (name, duration, price)
- Service duration drives slot sizing and availability calculations
- Staff–service assignments determine which staff can perform which services
- Archiving allows services to be retired without breaking historical bookings

### 3) Authentication

Authentication and access control are implemented using roles and permissions, with support for both web and API flows:

- Web login for browsing the platform and using the admin panel
- REST API authentication using Laravel Sanctum (Bearer tokens)
- Register and login endpoints for API clients
- Sanctum-protected endpoints for creating bookings and other authenticated actions

### 4) Admin Panel

The admin panel provides operational tooling for managing the booking business:

- Dashboard metrics (users, bookings, services, revenue totals)
- Reports (booking trends and revenue breakdowns)
- CRUD workflows for users, services, and staff
- Booking and invoice management, including status-driven behaviors
- Permission checks to ensure users only access what they’re allowed to manage

## Key Benefits

- Reliable scheduling with conflict detection
- Clear role separation (Admin, Staff, Customer)
- Extensible foundation for adding payments, notifications, and additional API endpoints
- Integration-ready via REST API (Sanctum) for mobile and SPA clients

