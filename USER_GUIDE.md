# User Guide (Customer)

This guide walks you through the main actions you can do in the booking system.

---

## 1) Register (Create an account)

1. Open the Register page: `http://127.0.0.1:8000/register` (or your `APP_URL` + `/register`)
2. Fill in:
   - Name
   - Email
   - Password
   - Password confirmation
3. Click **Create account**

After registration, you will be signed in automatically and redirected to your bookings page.

---

## 2) Login

1. Open the Login page: `http://127.0.0.1:8000/login`
2. Enter your:
   - Email
   - Password
3. Click **Sign in**

If you already have bookings, you’ll land on your bookings list after login.

---

## 3) Browse services

1. Open the services listing page: `http://127.0.0.1:8000/services-listing`
2. Review each service’s:
   - Name
   - Duration
   - Price
3. Optional: open a service details page to read more:
   - `http://127.0.0.1:8000/services/{id}`

From the services page or a service details page, choose **Book now** to start booking.

---

## 4) Book an appointment

1. Open the booking page:
   - `http://127.0.0.1:8000/book-appointment`
2. Sign in if prompted (booking requires an account).
3. On the booking form, choose:
   - Staff member
   - Service
   - Date
4. Time slots will load automatically after selecting staff, service, and date.
5. Select a time slot
6. (Optional) Add notes
7. Click **Submit booking**

If the selected time slot is available, your booking will be created and you’ll be able to view it in **My bookings** (`/bookings`).

