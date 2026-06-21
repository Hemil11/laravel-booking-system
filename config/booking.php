<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Booking alert recipients
    |--------------------------------------------------------------------------
    |
    | Comma-separated list of email addresses to notify when a new booking
    | is created (e.g. staff inbox). Leave empty to send only to the customer.
    |
    */

    'alert_emails' => array_values(array_filter(array_map(
        'trim',
        explode(',', (string) env('BOOKING_ALERT_EMAILS', ''))
    ))),

];
