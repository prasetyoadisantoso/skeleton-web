<?php

return [
    'title' => 'Meta',
    'breadcrumb' => [
        'title' => 'Pengaturan Meta',
        'home' => 'Beranda',
        'index' => 'Halaman Index',
        'create' => 'Halaman Pembuatan',
        'edit' => 'Halaman Edit',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Manajemen Meta',
        ],
        'table' => [
            'number' => 'No',
            'title' => 'Judul',
            'name' => 'Nama',
            'robot' => 'Robots',
            'description' => 'Deskripsi',
            'keywords' => 'Keywords',
            'action' => 'Aksi',
        ],
        'search' => 'Pencarian: ',
        'previous' => 'Sebelumnya',
        'next' => 'Selanjutnya',
        'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
        'length_menu' => 'Tampilkan _MENU_ entri',
    ],

    'form' => [
        'create_title' => 'Pembuatan Meta',
        'edit_title' => 'Edit Meta',
        'name' => 'Nama :',
        'name_placeholder' => 'Masukkan nama meta...',
        'title' => 'Judul :',
        'title_placeholder' => 'Masukkan judul meta...',
        'robot' => 'Robots :',
        'robot_placeholder' => 'Masukkan teks robot...',
        'description' => 'Deskripsi :',
        'description_placeholder' => 'Masukkan teks descripsi...',
        'keyword' => 'Keyword :',
        'keyword_placeholder' => 'Masukkan teks keyword...',
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
        'title_required' => 'Judul wajib diisi',
        'robot_required' => 'Teks robots wajib diisi',
        'description_required' => 'Deskripsi wajib diisi',
        'keyword_required' => 'Keyword wajib diisi',
    ],
];
