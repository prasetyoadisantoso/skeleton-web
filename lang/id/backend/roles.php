<?php

return [
    'title' => "Peran",
    'breadcrumb' => [
        'title' => 'Peran',
        'home' => 'Beranda',
        'index' => 'Halaman Index',
        'create' => 'Halaman Pembuatan',
        'edit' => 'Halaman Edit',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Manajemen Peran',
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Peran',
            'permission' => 'Izin',
            'action' => 'Aksi',
        ],
        'search' => 'Pencarian: ',
        'previous' => 'Sebelumnya',
        'next' => 'Selanjutntya',
        'info' => "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        'length_menu' => 'Menampilkan _MENU_ entri',
    ],

    'form' => [
        'create_title' => 'Pembuatan Peran',
        'edit_title' => 'Edit Peran',
        'name' => 'Nama Peran :',
        'name_placeholder' => 'Nama peran...',
        'permission_list' => 'Daftar izin :',
    ],

    'messages' => [
        'store_success' => 'Peran berhasil disimpan',
        'store_failed' => 'Peran gagal disimpan',
        'update_success' => 'Peran berhasil diperbarui',
        'update_failed' => 'Peran gagal diperbarui',
        'ask_delete' => 'Apakah anda yakin menghapus ini?',
        'delete_success' => 'Peran berhasil dihapus',
        'delete_failed' => 'Peran gagal dihapus',
    ],

    'validation' => [
        'name_required' => 'Nama peran wajib diisi',
    ],
];
