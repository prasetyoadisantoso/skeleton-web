<?php

return [
    'title' => 'Schema',
    'breadcrumb' => [
        'title' => 'Pengaturan Schema',
        'home' => 'Beranda',
        'index' => 'Halaman Index',
        'create' => 'Halaman Pembuatan',
        'edit' => 'Halaman Edit',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Manajemen Schema',
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Nama',
            'type' => 'Tipe',
            'content' => 'Konten',
            'action' => 'Aksi',
        ],
        'search' => 'Cari: ',
        'previous' => 'Sebelumnya',
        'next' => 'Selanjutnya',
        'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
        'length_menu' => 'Tampilkan _MENU_ entri',
    ],

    'form' => [
        'create_title' => 'Buat Schema',
        'edit_title' => 'Edit Schema',
        'type' => 'Tipe :',
        'type_placeholder' => 'Masukkan tipe schema...',
        'content' => 'Konten :',
        'content_placeholder' => 'Masukkan konten schema...',
    ],

    'messages' => [
        'store_success' => 'Data berhasil di simpan',
        'store_failed' => 'Data gagal disimpan',
        'update_success' => 'Data berhasil diperbarui',
        'update_failed' => 'Data gagal diperbarui',
        'ask_delete' => 'Apakah anda yakin menghapus ini?',
        'delete_success' => 'Data berhasil dihapus',
        'delete_failed' => 'Data gagal dihapus',
    ],

    'validation' => [
        'type_required' => 'Tipe Schema wajib diisi',
        'content_required' => 'Content Schema wajib diisi',
    ],
];
