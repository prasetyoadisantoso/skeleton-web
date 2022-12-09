<?php

return [
    'title' => "Aktivitas",
    'breadcrumb' => [
        'title' => 'Pengaturan Aktivitas',
        'home' => 'Beranda',
        'index' => 'Halaman Index',
        'create' => 'Halaman Pembuatan',
        'edit' => 'Halaman Edit',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Aktivitas Manajemen',
        ],
        'table' => [
            'number' => 'No',
            'ip_address' => 'Alamat IP',
            'user' => 'Nama',
            'activity' => 'Aktivitas',
            'date' => 'Tanggal',
            'time' => 'Waktu',
            'model' => 'Model',
            'action' => 'Aksi',
        ],
        'search' => 'Pencarian: ',
        'previous' => 'Sebelumnya',
        'next' => 'Selanjutntya',
        'info' => "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        'length_menu' => 'Menampilkan _MENU_ entri',
    ],

    'messages' => [
        'ask_empty' => 'Apakah anda yakin menghapus semua aktivitas?',
        'ask_delete' => 'Apakah anda yakin menghapus aktivitas ini?',
        'delete_success' => 'Data berhasil dihapus',
        'delete_failed' => 'Data gagal dihapus',
    ],
];
