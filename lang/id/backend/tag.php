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
        'meta' => 'SEO Meta :',
        'select_meta' => '- Pilih Meta -',
        'opengraph' => 'SEO Open Graph :',
        'select_opengraph' => '- Pilih Open Graph -',
    ],

    'messages' => [
        'store_success' => 'Tag berhasil disimpan',
        'store_failed' => 'Tag gagal disimpan',
        'update_success' => 'Tag berhasil diperbarui',
        'update_failed' => 'Tag gagal diperbarui',
        'ask_delete' => 'Apakah anda ingin menghapus tag ini?',
        'delete_success' => 'Tag berhasil dihapus',
        'delete_failed' => 'Tag gagal dihapus',
    ],

    'validation' => [
        'name_required' => 'Nama wajib diisi',
        'slug_required' => 'Slug wajib diisi',
    ],
];
