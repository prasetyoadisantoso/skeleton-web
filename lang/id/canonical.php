<?php

return [
    'title' => "Canonical",
    'breadcrumb' => [
        'title' => 'Pengaturan Canonical',
        'home' => 'Beranda',
        'index' => 'Halaman Index',
        'create' => 'Halaman Pembuatan',
        'edit' => 'Halaman Edit',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Canonical Manajemen',
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Nama',
            'url' => 'Alamat Url',
            'action' => 'Aksi',
        ],
        'search' => 'Pencarian: ',
        'previous' => 'Sebelumnya',
        'next' => 'Selanjutntya',
        'info' => "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        'length_menu' => 'Menampilkan _MENU_ entri',
    ],

    'form' => [
        'create_title' => 'Pembuatan Canonical',
        'edit_title' => 'Edit Canonical',
        'name' => 'Nama :',
        'name_placeholder' => 'Masukkan nama canonical...',
        'url' => 'Alamat url :',
        'url_placeholder' => 'Masukkan alamat url...',
    ],

    'messages' => [
        'store_success' => 'Data berhasil disimpan',
        'store_failed' => 'Data gagal disimpan',
        'update_success' => 'Data berhasil diperbarui',
        'update_failed' => 'Data gagal diupdate',
        'ask_delete' => 'Apakah anda yakin menghapus data ini?',
        'delete_success' => 'Data berhasil dihapus',
        'delete_failed' => 'Data gagal dihapus',
    ],

    'validation' => [
        'name_required' => 'Nama canonical wajib diisi',
        'url_required' => 'Alamat canonical wajib diisi',
    ],
];
