# API Documentation (Laravel Sanctum)

Base URL: `{APP_URL}/api` (example: `http://127.0.0.1:8000/api`)  
Always send: `Accept: application/json`

---

## Response Format

### Success (2xx)
```json
{
  "success": true,
  "message": "OK",
  "data": { }
}
```

### Error (4xx)
```json
{
  "success": false,
  "message": "Error message",
  "errors": { }
}
```

Notes:
- Validation errors return `422` with a field-level `errors` object.
- Unauthenticated API calls return `401` with `errors: null`.

---

## Authentication (Sanctum)

The API uses Laravel Sanctum tokens (Bearer tokens).

Authenticated request header:
- `Authorization: Bearer {token}`

Public endpoints:
- `POST /api/register`
- `POST /api/login`

Sanctum-protected endpoint:
- `POST /api/bookings`

---

## Endpoints

### 1) Register
`POST /api/register` (public)

Request body (JSON):
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
    "user": {
      "id": 1,
      "name": "Jane Customer",
      "email": "jane.customer@example.com"
    }
  }
}
```

---

### 2) Login
`POST /api/login` (public)

Request body (JSON):
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
    "user": {
      "id": 1,
      "name": "Admin Name",
      "email": "admin@example.com"
    }
  }
}
```

---

### 3) Services list
`GET /api/services` (public)

Request body:
- none

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

---

### 4) Available slots
`GET /api/available-slots` (public)

Query parameters:
- `staff_id` (required, integer; exists in `staffs`)
- `service_id` (required, integer; exists in `services`)
- `date` (required, date string `YYYY-MM-DD`; must be `today` or later)

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

---

### 5) Create booking
`POST /api/bookings` (authenticated, Sanctum)

Headers:
- `Authorization: Bearer {token}`
- `Accept: application/json`
- `Content-Type: application/json`

Request body (JSON):
```json
{
  "staff_id": 1,
  "service_id": 1,
  "date": "2026-03-27",
  "time": "09:00",
  "notes": "Optional note for the booking."
}
```

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
- `401` if token is missing/invalid
- `409` if the selected slot conflicts with an existing booking
- `422` for request validation errors

