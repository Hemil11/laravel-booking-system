# Future Roadmap (Vision, Realistic Milestones)

This project is designed as a strong starting point for a production-grade booking platform. Planned enhancements focus on payments, scheduling UX, communication, scalability, and channel expansion.

---

## 1) Payment integration

- Replace the current demo “mock payment” with real payments (e.g., Stripe/PayPal).
- Support payment lifecycle states (authorized, captured, refunded) and sync booking status accordingly.
- Add webhooks for reliable payment status updates.

---

## 2) Calendar view upgrades

- Improve the calendar UI with smoother drag-and-drop and richer slot visualization.
- Add per-service/per-staff views and better conflict highlighting.
- Support recurring appointments and bulk booking patterns (where business rules allow).

---

## 3) Notifications (more channels + smarter triggers)

- Expand beyond email to include SMS and/or WhatsApp for booking confirmations and reminders.
- Add configurable notification schedules (remind X hours/days before appointment).
- Improve personalization (service name, staff name, confirmation/changes history).

---

## 4) Multi-tenant support

- Introduce tenant isolation so multiple businesses can run in the same app:
  - tenant-aware data scoping (services, staff, bookings, invoices)
  - tenant-specific configuration (working hours, taxes, notification emails)
- Add a tenant switcher and tenant-scoped permissions for administrators.

---

## 5) Mobile app support

- Prepare the system for mobile clients by formalizing/expanding the REST API.
- Add push notifications for booking updates and reminders.
- Optionally introduce a mobile-friendly booking experience (mobile web now, native app later) using the same API backend.

