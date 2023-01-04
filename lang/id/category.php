<?php

return [
    'title' => "Kategori",
    'breadcrumb' => [
        'title' => 'Pengaturan Kategori',
        'home' => 'Beranda',
        'index' => 'Halaman Index',
        'create' => 'Halaman Pembuatan',
        'edit' => 'Halaman Edit',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Manajemen Kategori',
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
        'create_title' => 'Pembuatan Kategori',
        'edit_title' => 'Edit Kategori',
        'name' => 'Nama :',
        'name_placeholder' => 'Masukkan nama kategori...',
        'slug' => 'Slug :',
        'slug_placeholder' => 'Masukkan slug kategori...',
        'parent' => 'Parent :',
        'parent_placeholder' => '- Pilih Parent Kategori -'
    ],

    'messages' => [
        'store_success' => 'Kategori berhasil disimpan',
        'store_failed' => 'Kategori gagal disimpan',
        'update_success' => 'Kategori berhasil diperbarui',
        'update_failed' => 'Kategori gagal diperbarui',
        'ask_delete' => 'Apakah anda ingin menghapus kategori ini?',
        'delete_success' => 'Kategori berhasil dihapus',
        'delete_failed' => 'Kategori gagal dihapus',
    ],

    'validation' => [
        'name_required' => 'Nama wajib diisi',
        'slug_required' => 'Slug wajib diisi',
        'parent_required' => 'Parent wajib diisi'
    ],
];
