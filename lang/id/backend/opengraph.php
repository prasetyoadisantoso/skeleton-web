<?php

return [
    'title' => "Open Graph",
    'breadcrumb' => [
        'title' => 'Pengaturan Open Graph',
        'home' => 'Beranda',
        'index' => 'Halaman Index',
        'create' => 'Halaman Pembuatan',
        'edit' => 'Halaman Edit',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Manajemen Open Graph',
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Nama',
            'title' => 'Judul',
            'description' => 'Deskripsi',
            'url' => 'URL',
            'site_name' => 'Nama Situs',
            'image' => 'Gambar',
            'type' => 'Tipe',
            'action' => 'Aksi',
        ],
        'search' => 'Cari: ',
        'previous' => 'Sebelumnya',
        'next' => 'Selanjutnya',
        'info' => "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        'length_menu' => 'Tampilkan _MENU_ entri',
    ],

    'form' => [
        'create_title' => 'Buat Open Graph',
        'edit_title' => 'Edit Open Graph',
        'name' => 'Nama :',
        'name_placeholder' => 'Masukkan nama open graph...',
        'title' => 'Judul :',
        'title_placeholder' => 'Masukkan judul...',
        'description' => 'Deskripsi :',
        'description_placeholder' => 'Masukkan deskripsi...',
        'url' => 'Alamat URL :',
        'url_placeholder' => 'Masukkan alamat URL...',
        'site_name' => 'Nama situs :',
        'site_name_placeholder' => 'Masukkan nama situs...',
        'image' => 'Image: ',
        'image_placeholder' => 'Pilih gambar...',
        'type' => 'Tipe Konten: ',
        'type_placeholder' => 'Masukkan tipe konten...',
    ],

    'messages' => [
        'store_success' => 'Data stored successfully',
        'store_failed' => 'Data failed to store',
        'update_success' => 'Data updated successfully',
        'update_failed' => 'Data failed to update',
        'ask_delete' => 'Do you want to delete this permission?',
        'delete_success' => 'Data deleted successfully',
        'delete_failed' => 'Data failed to delete',
    ],

    'validation' => [
        'name_required' => 'Nama open graph wajib diisi',
        'title_required' => 'Judul wajib diisi',
        'description_required' => 'Deskripsi wajib diisi',
        'url_required' => 'Alamat url wajib diisi',
        'site_name_required' => 'Nama situs wajib diisi',
        'type' => 'Tipe konten wajib diisi',
    ],
];
