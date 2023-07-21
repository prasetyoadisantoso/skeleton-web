<?php

return [

    'breadcrumb' => [
        'title' => 'Pengguna',
        'home' => 'Beranda',
        'index' => 'Halaman Index',
        'create' => 'Halaman Pembuatan',
        'edit' => 'Halaman Edit',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Manajemen Pengguna'
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Nama',
            'image' => 'Gambar',
            'email' => 'Email',
            'role' => 'Peranan',
            'action' => 'Aksi',
        ],
        'search' => 'Pencarian: ',
        'previous' => 'Sebelumnya',
        'next' => 'Selanjutnya',
        'info' => "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        'length_menu' => 'Tampilkan _MENU_ entri',
    ],

    'detail' => [
        'title' => 'Rincian Pengguna',
        'name' => 'Nama',
        'email' => 'Email',
        'phone' => 'Nomor Telepon',
        'role' => 'Peran',
        'is_verified' => 'Apakah sudah terverifikasi ?',
    ],

    'form' => [
        'create_title' => 'Pembuatan Pengguna',
        'edit_title' => 'Edit Pengguna',
        'image_note' => '*Klik gambar diatas untuk unggah gambar',
        'name' => 'Nama Lengkap :',
        'name_placeholder' => 'Nama lengkap...',
        'email' => 'Email :',
        'email_placeholder' => 'Email...',
        'phone' => 'No Telepon :',
        'phone_placeholder' => 'Nomor telepon...',
        'role' => 'Peranan :',
        'role_placeholder' => 'Pilih peran...',
        'password' => 'Password :',
        'password_placeholder' => 'Password...',
        'confirm_password' => 'Konfirmasi Password :',
        'confirm_password_placeholder' => 'Konfirmasi password...',
        'verification_status' => 'Status Verifikasi :',
    ],

    'messages' => [
        'store_success' => 'Berhasil menyimpan pengguna',
        'store_failed' => 'Gagal menyimpan pengguna',
        'update_success' => 'Pengguna berhasil diperbarui',
        'update_failed' => 'Pengguna gagal diperbarui',
        'image_not_available' => 'Gambar tidak tersedia',
        'ask_delete' => 'Apakah anda yakin menghapus pengguna ini?',
        'delete_success' => 'Berhasi menghapus pengguna',
        'delete_failed' => 'Gagal menghapus pengguna',
    ],

    'validation' => [
        'fullname_required' => 'nama lengkap wajib diisi',
        'email_required' => 'email wajib diisi',
        'email_contained' => 'email wajib sesuai format',
        'phone_required' => 'nomor telepon wajib diisi',
        'role_required' => "peran wajid dipilih",
        'password_required' => 'password wajib diisi',
        'confirm_password_required' => 'konfirmasi password wajib diisi',
        'confirm_password_same' => 'konfirmasi password wajib sama dengan password',
    ],
];
