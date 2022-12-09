<?php
return [
    'title' => 'Perawatan',
    'breadcrumb' => [
        'title' => 'Pengaturan Perawatan',
        'home' => 'Beranda',
        'index' => 'Halaman Index'
    ],
    'form' => [
        'clean_cache_system' => [
            'title' => 'Pembersih Sampah Sistem',
            'description' => 'Bersihkan sampah sistem dengan skali klik',
            'event_clear' => 'Bersihkan sampah "event"',
            'view_clear' => 'Bersihkan sampah "view"',
            'cache_clear' => 'Bersihkan sampah sistem',
            'config_clear' => 'Bersihkan sampah konfigurasi sistem',
            'route_clear' => 'Bersihykan sampah "route"',
            'compile_clear' => 'Bersihkan sampah "service" dan "package"',
            'optimize_clear' => 'Optimasi Sistem'
        ],
        'coming_soon' => [
            'message' => 'Coming Soon!'
        ],
    ],
    'messages' => [
        'action_success' => 'Pembersihan Sukses',
        'action_failed' => 'Pembersihan Gagal',
    ],
];
