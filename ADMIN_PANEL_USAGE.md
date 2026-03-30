# Admin Panel Usage Guide

This guide explains how to use the admin panel in the Laravel booking system. The UI is permission-based: you will only see actions you have been granted (for example, `manage_users`, `manage_services`, `manage_bookings`).

---

## 1) Dashboard Overview

Go to: `/admin`

The dashboard shows key metrics “at a glance”, including:

- Total users
- Total bookings
- Total services
- Revenue (sum of paid invoice totals)

Quick action:

- “Create booking” takes you to the booking creation form (`/bookings/create`).

---

## 2) Managing Users

Go to: `/admin/users`

### What you can do

- Browse user accounts with pagination
- Filter users to quickly find what you need
- Add new users
- Edit existing users
- Delete users (via row actions and bulk actions)
- Bulk update email verification status

### Filters

Use the filter bar to narrow results:

- `Search` by name or email
- `Verification` status:
  - Verified
  - Unverified
  - (Optional) “Any verification” depending on the page configuration
- `Registered from` / `Registered to` (date range)

Click **Apply filters** to refresh the list, or **Reset** to clear filters.

### Bulk actions

1. Select multiple users using the checkboxes.
2. Use the bulk status dropdown to choose an action (for example, mark verified / mark unverified).
3. Click **Apply status**.
4. Or click **Delete selected** to remove accounts (the app avoids deleting your own account).

---

## 3) Managing Services

Go to: `/services`

This section is for managing the service catalog (what customers can book).

### What you can do

- Browse services (including archived ones, depending on filters)
- Create a service
- Edit a service
- Delete/archive services
- Restore archived services
- Use bulk actions to update multiple services at once

### Filters

Use the filter bar to search and narrow results:

- `Search` by service name or description
- `Catalog` status:
  - Active
  - Archived
  - All (including archived)
- `Created from` / `Created to` (date range)

### Bulk actions

To bulk-manage services:

1. Select services using the checkboxes.
2. Optionally choose a bulk status from the dropdown:
   - Restore (make active again)
   - Archive
3. Click **Apply status**.
4. Or click **Archive selected** to archive (soft-delete) items.

---

## 4) Managing Bookings

Bookings can be managed in two places:

- List view: `/bookings`
- Calendar view: `/bookings/calendar`

### A) Bookings list (filters + bulk actions)

Go to: `/bookings`

#### Filters

Use the filter bar to narrow booking records:

- `Search` by customer, staff, service, booking ID, or status
- `Status`:
  - You can choose a specific status, or use “All statuses”
- `Appointment from` / `Appointment to` (date range)

Click **Apply filters** to update the table.

#### Bulk actions (cancel / set status)

1. Select bookings using the checkboxes.
2. Use the bulk status dropdown to choose a status to apply (for example: pending, confirmed, completed, cancelled).
3. Click **Apply status**.
4. Or click **Cancel selected bookings** to cancel bookings in bulk (this also frees the time slots).

Note: which status transitions are allowed depends on your permissions (the controller also checks authorization per booking).

#### Row actions

Each booking row supports:

- **View** (details page)
- **Cancel** (only when the booking is not already cancelled)

### B) Booking calendar (day/week + clickable free slots)

Go to: `/bookings/calendar`

The calendar shows day/week views of booked appointments.

Key features:

- Toggle between **Day** and **Week**
- Navigate to previous/next day or week, or jump to **Today**
- Use **Staff filter** to display free working-hours slots as clickable booking links

How to use the calendar:

1. Select a staff member from the **Staff filter**.
2. Empty working hours are converted into clickable slots.
3. Click a slot to open the booking form with date/time prefilled.

---

## 5) Using Filters and Bulk Actions (Quick Reference)

### Filters (common pattern)

- All admin list pages provide a filter bar.
- Filters typically use these query fields:
  - `search` (keyword)
  - `status` (page-specific status)
  - `date_from` / `date_to` (date range)
- Use:
  - **Apply filters** to reload results
  - **Reset** to clear everything

### Bulk actions (common pattern)

Bulk controls work the same way across users/services/bookings/invoices:

- Select items with checkboxes (there is a “select all on this page” control)
- Choose a bulk status (optional, when the page supports it)
- Click:
  - **Apply status** to apply the chosen status to selected items
  - **Delete selected** / **Cancel selected** to perform the destructive action

