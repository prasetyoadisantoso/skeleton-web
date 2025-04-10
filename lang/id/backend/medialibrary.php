<?php

return [
    'title' => "Pustaka Media",
    'breadcrumb' => [
        'title' => 'Pustaka Media',
        'home' => 'Beranda',
        'index' => 'Halaman Index',
        'create' => 'Halaman Pembuatan',
        'edit' => 'Halaman Edit',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Manajemen Media Pustaka',
        ],
        'table' => [
            'number' => 'No',
            'title' => 'Judul',
            'media_files' => 'File Media',
            'action' => 'Aksi',
        ],
        'search' => 'Pencarian: ',
        'previous' => 'Sebelumnya',
        'next' => 'Selanjutnta',
        'info' => "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
        'length_menu' => 'Tampilkan _MENU_ data',
    ],

    'form' => [
        'create_title' => 'Buat File',
        'edit_title' => 'Edit File',
        'title' => 'Judul :',
        'title_placeholder' => 'Masukkan Judul...',
        'information' => 'Informasi :',
        'information_placeholder' => 'Masukkan Informasi...',
        'description' => 'Deskripsi :',
        'description_placeholder' => 'Masukkan deskripsi anda disini...',
        'mediafile' => 'File Media :',
    ],

    'messages' => [
        'store_success' => 'Media File berhasil disimpan',
        'store_failed' => 'Media File gagal menyimpan',
        'update_success' => 'Media File berhasil diperbarui',
        'update_failed' => 'Media File gagal diperbarui',
        'ask_delete' => 'Apakah anda yakin menghapus file ini?',
        'delete_success' => 'Media File berhasil dihapus',
        'delete_failed' => 'Media File gagal dihapus',
        'mediafile_not_available' => 'Media File tidak tersedia',
    ],

    'validation' => [
        'title_required' => 'Judul wajib diisi',
        'content_required' => 'Content is required',
        'feature_image_required' => 'Feature image is required',
    ],
];
