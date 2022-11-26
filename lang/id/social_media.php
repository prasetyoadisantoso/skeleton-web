<?php

return [
    'title' => "Media Sosial",
    'breadcrumb' => [
        'title' => 'Media Sosial',
        'home' => 'Beranda',
        'index' => 'Halaman Index',
        'create' => 'Halaman Pembuatan',
        'edit' => 'Halaman Edit',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Media Sosial Manajemen',
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Nama',
            'url' => 'Alamat Url',
            'action' => 'Action',
        ],
        'search' => 'Search: ',
        'previous' => 'Previous',
        'next' => 'Next',
        'info' => "Showing _START_ to _END_ of _TOTAL_ entries",
        'length_menu' => 'Show _MENU_ entries',
    ],

    'form' => [
        'create_title' => 'Pembuatan Sosial Media',
        'edit_title' => 'Edit Sosial Media',
        'name' => 'Nama :',
        'name_placeholder' => 'Masukkan nama sosial media...',
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
        'name_required' => 'Nama social media wajib diisi',
        'url_required' => 'Alamat social media wajib diisi',
    ],
];
