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
            'generate_sitemap' => 'Generate sitemap for google indexing',
            'event_clear' => 'Command to clear the event cache',
            'view_clear' => 'Command to clear the view cache',
            'cache_clear' => 'Command to clear the system cache',
            'config_clear' => 'Command to clear the config cache',
            'route_clear' => 'Command to clear the route cache',
            'compile_clear' => 'Command to clear the compiled services and packages',
            'optimize_clear' => 'Optimizing System'
        ],
        'factory_reset' => 'Factory Reset!',
        'coming_soon' => [
            'message' => 'Coming Soon!'
        ],
        'additional' => [
            'title' => 'Additional Feature for Maintenance Your System',
            'generate_sitemap' => 'Generate sitemap for google indexing',
        ]
    ],
    'messages' => [
        'generate_success' => 'Generate Sukses',
        'generate_failed' => 'Generate Failed',
        'action_success' => 'Clear Success!',
        'action_failed' => 'Clear Failed!',
        'ask_reset' => 'Be Careful, All Data will be reset. Reset Now? ',
        'reset_success' => 'Reset Success!',
        'reset_failed' => 'Reset Failed, Use Recovery Command',
    ],
];
