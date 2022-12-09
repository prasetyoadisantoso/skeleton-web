<?php
return [
    'title' => 'Maintenance',
    'breadcrumb' => [
        'title' => 'Maintenance Setting',
        'home' => 'Home',
        'index' => 'Index Page',
    ],
    'form' => [
        'clean_cache_system' => [
            'title' => 'Cache System Cleaner',
            'description' => 'Clean the cache system with one click action',
            'event_clear' => 'Command to clear the event cache',
            'view_clear' => 'Command to clear the view cache',
            'cache_clear' => 'Command to clear the system cache',
            'config_clear' => 'Command to clear the config cache',
            'route_clear' => 'Command to clear the route cache',
            'compile_clear' => 'Command to clear the compiled services and packages',
            'optimize_clear' => 'Optimizing System'
        ],
        'coming_soon' => [
            'message' => 'Coming Soon!'
        ],
    ],
    'messages' => [
        'action_success' => 'Clear Success!',
        'action_failed' => 'Clear Failed!',
    ],
];
