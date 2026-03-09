<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Backend API Base URL
    |--------------------------------------------------------------------------
    | This is the base URL for all API calls made from the frontend to the
    | backend. When running in Docker, use the service name (e.g. backend).
    | For local development without Docker, use host.docker.internal or localhost.
    |
    */
    'base_url' => env('KLE_API_URL', 'http://backend:8000/api'),
];
