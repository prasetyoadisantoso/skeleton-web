<?php

return [
    'title' => "Pesan",
    'breadcrumb' => [
        'title' => 'Pesan',
        'home' => 'Beranda',
        'index' => 'Halaman Index',
        'create' => 'Halaman Pembuatan',
        'edit' => 'Halaman Edit',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Manajemen Pesan',
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Nama',
            'email' => 'Email',
            'read_at' => 'Dibaca pada',
            'action' => 'Aksi',
        ],
        'search' => 'Pencarian: ',
        'previous' => 'Sebelumnya',
        'next' => 'Selanjutnya',
        'info' => "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        'length_menu' => 'Tampilkan _MENU_ entri',
    ],

    'form' => [
        'create_title' => 'Pembuatan Meta',
        'edit_title' => 'Edit Meta',
        'name' => 'Nama :',
        'name_placeholder' => 'Masukkan nama meta...',
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

    'detail' => [
        'name' => 'Nama :',
        'email' => 'Email :',
        'phone' => 'Nomor Telepon :',
        'message' => 'Pesan :',
        'switch' => 'Switch untuk menandai Sudah Baca atau Belum Baca'
    ],

    'validation' => [
        'name_required' => 'Nama wajib diisi',
        'robot_required' => 'Teks robots wajib diisi',
        'description_required' => 'Deskripsi wajib diisi',
        'keyword_required' => 'Keyword wajib diisi',
    ],
];
