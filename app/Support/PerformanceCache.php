<?php

namespace App\Support;

final class PerformanceCache
{
    public const API_SERVICES_INDEX = 'perf:api:services:index:v1';

    public const ADMIN_DASHBOARD_STATS = 'perf:admin:dashboard:stats:v1';

    public const REPORTS_PAGE = 'perf:admin:reports:page:v1';

    public const BOOKING_FORM_STAFF = 'perf:booking-form:active-staff:v1';

    public const BOOKING_FORM_SERVICES = 'perf:booking-form:services:v1';

    public static function forgetBookingDropdowns(): void
    {
        cache()->forget(self::BOOKING_FORM_STAFF);
        cache()->forget(self::BOOKING_FORM_SERVICES);
    }
}
