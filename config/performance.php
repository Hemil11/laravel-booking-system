<?php

return [

    'api_services_ttl' => (int) env('CACHE_API_SERVICES_TTL', 300),

    'admin_dashboard_ttl' => (int) env('CACHE_ADMIN_DASHBOARD_TTL', 60),

    'reports_ttl' => (int) env('CACHE_REPORTS_TTL', 120),

    'booking_form_ttl' => (int) env('CACHE_BOOKING_FORM_TTL', 300),

];
