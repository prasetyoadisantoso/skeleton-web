<?php

return [
    'title' => "Tag",
    'breadcrumb' => [
        'title' => 'Pengaturan Tag',
        'home' => 'Beranda',
        'index' => 'Halaman Index',
        'create' => 'Halaman Pembuatan',
        'edit' => 'Halaman Edit',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Manajemen Tag',
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Nama',
            'slug' => 'Slug',
            'action' => 'Aksi',
        ],
        'search' => 'Pencarian: ',
        'previous' => 'Sebelumnya',
        'next' => 'Selanjutnya',
        'info' => "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        'length_menu' => 'Tampilkan _MENU_ entri',
    ],

    'form' => [
        'create_title' => 'Pembuatan Tag',
        'edit_title' => 'Edit Tag',
        'name' => 'Nama :',
        'name_placeholder' => 'Masukkan nama tag...',
        'slug' => 'Slug :',
        'slug_placeholder' => 'Masukkan slug tag...',
    ],

    'messages' => [
        'store_success' => 'Data berhasil disimpan',
        'store_failed' => 'Data gagal disimpan',
        'update_success' => 'Data berhasil diperbarui',
        'update_failed' => 'Data gagal diperbarui',
        'ask_delete' => 'Apakah anda ingin menghapus data ini?',
        'delete_success' => 'Data berhasil dihapus',
        'delete_failed' => 'Data gagal dihapus',
    ],

    'validation' => [
        'name_required' => 'Nama wajib diisi',
        'slug_required' => 'Slug wajib diisi',
    ],
];
