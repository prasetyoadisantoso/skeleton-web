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
            'description' => 'Bersihkan sampah sistem dengan sekali klik',
            'event_clear' => 'Bersihkan sampah "event"',
            'view_clear' => 'Bersihkan sampah "view"',
            'cache_clear' => 'Bersihkan sampah sistem',
            'config_clear' => 'Bersihkan sampah konfigurasi sistem',
            'route_clear' => 'Bersihykan sampah "route"',
            'compile_clear' => 'Bersihkan sampah "service" dan "package"',
            'optimize_clear' => 'Optimasi Sistem'
        ],
        'factory_reset' => 'Reset Pabrik!',
        'coming_soon' => [
            'message' => 'Coming Soon!'
        ],
        'additional' => [
            'title' => 'Fitur Tambahan untuk Perawatan Website',
            'generate_sitemap' => 'Generate sitemap untuk google index',
        ]
    ],
    'messages' => [
        'action_success' => 'Pembersihan Sukses',
        'generate_success' => 'Generate Sukses',
        'action_failed' => 'Pembersihan Gagal',
        'ask_reset' => 'Peringatan, Semua data akan di hapus. Setel Ulang? ',
        'reset_success' => 'Setel Ulang Berhasil!',
        'reset_failed' => 'Setel Ulang Gagal, Gunakan Recovery Command',
    ],
];
