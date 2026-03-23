<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Party Details
    |--------------------------------------------------------------------------
    |
    | Configure the party information displayed on the dashboard.
    |
    */

    'name' => env('PARTY_NAME', 'Party 2026'),

    'date' => env('PARTY_DATE', '2026-07-04'),

    'time_start' => env('PARTY_TIME_START', '18:00'),

    'time_end' => env('PARTY_TIME_END', '04:00'),

    'registration_deadline' => env('PARTY_REGISTRATION_DEADLINE'),

    'location' => [
        'name' => env('PARTY_LOCATION_NAME', 'Venue TBD'),
        'address' => env('PARTY_LOCATION_ADDRESS', 'Address TBD'),
        'city' => env('PARTY_LOCATION_CITY', 'City TBD'),
        // Latitude and longitude for the map pin
        'lat' => env('PARTY_LAT', '52.5200'),
        'lon' => env('PARTY_LON', '13.4050'),
    ],

];
