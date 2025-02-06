<?php

return [
    // ... other configurations ...
    
    'providers' => [
        // ... other providers ...
        
        /*
         * Package Service Providers...
         */
        
        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\ViewServiceProvider::class, // Add this line
    ],
    
    // ... rest of the configuration
];
