# Testing Guide (Laravel Booking System)

This guide shows how to verify the most important user and admin workflows in this booking system with PHPUnit (Laravel Feature tests).

---

## 1) How to run tests

From the project root:

```bash
composer test
```

Or:

```bash
php artisan test
```

To run a single file:

```bash
php artisan test --filter Booking
```

---

## 2) Recommended test strategy

1. Use `RefreshDatabase` so each test starts with a clean, migrated sqlite database (as configured in `phpunit.xml`).
2. For admin-related tests, either:
   - run `php artisan db:seed` to get roles/permissions + demo users, or
   - create roles/permissions manually in the test.
3. For booking flow tests, always ensure the **staff offers the service**:
   - the `staff_service` pivot must have `is_active = true`
4. Use a future date (e.g., `today()->addDay()`), since the system blocks “past” dates and times.

---

## 3) How to test the booking flow

You can test booking flow in two ways:

### A) API booking flow (recommended for fast, deterministic checks)

Test steps:

1. Create a `staff` and a `service`, and attach the service to staff through `staff_service` with `is_active = true`.
2. Register or login a customer via:
   - `POST /api/register` (returns Sanctum Bearer token) or
   - `POST /api/login`
3. Request availability:
   - `GET /api/available-slots?staff_id=...&service_id=...&date=YYYY-MM-DD`
4. Create booking with the first available slot:
   - `POST /api/bookings` with `Authorization: Bearer {token}`
5. Assert:
   - booking was created
   - booking status is `pending`
   - booking slots exist in `booking_slots`
   - invoice exists for the booking (created on booking creation)

### B) Web booking flow (recommended to validate the UI integration)

Test steps:

1. Create staff + service + staff_service pivot (`is_active = true`).
2. Create a customer user and authenticate it (`actingAs`).
3. Submit the web form endpoint:
   - `POST /bookings` (handled by `BookingController@store`)
4. Assert:
   - redirect to `/bookings/{booking}`
   - booking exists in `bookings`
   - invoice exists in `invoices`

---

## 4) How to test login

### A) Web login

Test steps:

1. Create a user with a known password (the factory uses `password` by default).
2. Submit:
   - `POST /login` with `{ email, password }`
3. Assert:
   - redirect to `/bookings` (route used by `LoginController`)
   - the session user is authenticated

### B) API login (Sanctum)

Test steps:

1. Create a user.
2. Submit:
   - `POST /api/login` with `{ email, password }`
3. Assert:
   - HTTP 200
   - response contains `data.token`

---

## 5) How to test admin actions

Admin actions are protected with:
- `auth` middleware
- permission middleware like `permission:manage_users` (see `EnsurePermission`)

Test steps (using the built-in demo seed):

1. Run `php artisan db:seed` in the test.
2. Authenticate as the seeded admin:
   - `admin@admin.com` / `password`
3. Call a protected admin endpoint, for example:
   - `POST /admin/users/bulk`
4. Assert:
   - response is successful / redirects back
   - changes are reflected in the database (e.g., `email_verified_at` updated)

---

## 6) Sample test cases (copy/paste examples)

### Example 1: API booking flow test

```php
<?php

namespace Tests\Feature;

use App\Models\Staff;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingFlowApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_get_slots_and_create_booking_via_api(): void
    {
        $service = Service::factory()->create([
            'duration' => 60,
        ]);

        $staff = Staff::factory()->create([
            'full_name' => 'Test Staff',
            'is_active' => true,
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
        ]);

        // Staff must offer the service for booking availability + creation to work.
        $staff->services()->sync([
            $service->id => [
                'is_active' => true,
                'price_override_cents' => null,
                'currency' => 'USD',
            ],
        ]);

        // Register customer and get a Sanctum token.
        $customerEmail = 'customer-'.uniqid().'@example.com';
        $register = $this->postJson('/api/register', [
            'name' => 'Jane Customer',
            'email' => $customerEmail,
            'password' => 'Password1!',
            'password_confirmation' => 'Password1!',
        ]);

        $register->assertCreated();
        $token = $register->json('data.token');
        $this->assertIsString($token);

        $date = Carbon::today()->addDay()->toDateString();

        // Get available slots.
        $slotsResponse = $this->getJson(
            "/api/available-slots?staff_id={$staff->id}&service_id={$service->id}&date={$date}",
            ['Accept' => 'application/json']
        );
        $slotsResponse->assertOk();

        $slots = $slotsResponse->json('data.slots');
        $this->assertNotEmpty($slots);

        // slots[].start is H:i:s, but API booking expects H:i (24h).
        $time = substr($slots[0]['start'], 0, 5);

        $bookingResponse = $this->postJson('/api/bookings', [
            'staff_id' => $staff->id,
            'service_id' => $service->id,
            'date' => $date,
            'time' => $time,
            'notes' => 'Test booking via API',
        ], [
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
        ]);

        $bookingResponse->assertCreated();
        $bookingResponse->assertJsonPath('data.booking.status', 'pending');

        $bookingId = $bookingResponse->json('data.booking.id');
        $this->assertDatabaseHas('bookings', ['id' => $bookingId, 'status' => 'pending']);
        $this->assertDatabaseHas('booking_slots', ['booking_id' => $bookingId]);
        $this->assertDatabaseHas('invoices', ['booking_id' => $bookingId]);
    }
}
```

---

### Example 2: Web booking flow test

```php
<?php

namespace Tests\Feature;

use App\Models\Staff;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingFlowWebTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_booking_via_web(): void
    {
        $service = Service::factory()->create(['duration' => 60]);

        $staff = Staff::factory()->create([
            'full_name' => 'Test Staff',
            'is_active' => true,
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
        ]);

        $staff->services()->sync([
            $service->id => [
                'is_active' => true,
                'price_override_cents' => null,
                'currency' => 'USD',
            ],
        ]);

        $customer = User::factory()->create(); // password is factory default: "password"

        $date = Carbon::today()->addDay()->toDateString();

        $this->actingAs($customer)->post('/bookings', [
            'staff_id' => $staff->id,
            'service_id' => $service->id,
            'date' => $date,
            'time' => '09:00', // form sends H:i, backend converts to H:i:s
            'notes' => 'Web booking test',
        ])->assertRedirect();

        $this->assertDatabaseHas('bookings', [
            'user_id' => $customer->id,
            'staff_id' => $staff->id,
            'service_id' => $service->id,
            'date' => $date,
        ]);
    }
}
```

---

### Example 3: Admin bulk action test (manage users)

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUsersBulkTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_bulk_set_email_verification_status(): void
    {
        $this->artisan('db:seed');

        $admin = User::query()->where('email', 'admin@admin.com')->firstOrFail();
        $target = User::factory()->unverified()->create();

        $this->actingAs($admin)->post('/admin/users/bulk', [
            'bulk_action' => 'set_status',
            'ids' => [$target->id],
            'status_value' => 'verified',
        ])->assertRedirect();

        $this->assertNotNull(User::query()->find($target->id)->email_verified_at);
    }
}
```

---

### Example 4: Web login test

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_via_web_form(): void
    {
        $user = User::factory()->create([
            // UserFactory hashes password as "password" by default.
            'password' => bcrypt('password'),
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/bookings');

        $this->assertAuthenticatedAs($user);
    }
}
```

---

### Example 5: API login test (Sanctum)

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_via_api_and_receive_token(): void
    {
        $user = User::factory()->create([
            // UserFactory hashes password as "password" by default.
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertOk();
        $this->assertIsString($response->json('data.token'));
        $this->assertSame('Bearer', $response->json('data.token_type'));
    }
}
```

---

## 7) What to assert (checklist)

For each workflow, assert database state—not just HTTP status:

- `bookings` created/updated correctly (`status`, `date`, `time`, `staff_id`, `service_id`)
- `booking_slots` created for non-cancelled bookings
- `invoices` created and updated by payment actions
- admin permission checks (403 when missing permissions)

