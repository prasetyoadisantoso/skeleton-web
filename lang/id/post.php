<?php

return [
    'title' => "Post",
    'breadcrumb' => [
        'title' => 'Postingan',
        'home' => 'Beranda',
        'index' => 'Halaman Index',
        'create' => 'Halaman Pembuatan',
        'edit' => 'Halaman Edit',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Manajemen Postingan',
        ],
        'table' => [
            'number' => 'No',
            'title' => 'Judul',
            'image' => 'Gambar',
            'publish' => 'Publikasi',
            'action' => 'Action',
        ],
        'search' => 'Pencarian: ',
        'previous' => 'Sebelumnya',
        'next' => 'Selanjutnya',
        'info' => "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        'length_menu' => 'Menampilkan _MENU_ entri',
    ],

    'form' => [
        'create_title' => 'Buat Post',
        'edit_title' => 'Edit Post',
        'title' => 'Judul :',
        'title_placeholder' => 'Masukkan judul...',
        'slug' => 'Slug :',
        'slug_placeholder' => 'Masukkan slug...',
        'content' => 'Konten :',
        'content_placeholder' => 'Masukkan konten anda disini...',
        'category' => 'Kategori :',
        'select_category' => '- Pilih Kategori -',
        'tag' => 'Tag :',
        'select_tag' => 'Pilih beberapa tag',
        'meta' => 'SEO Meta :',
        'select_meta' => '- Pilih Meta -',
        'canonical' => 'SEO Canonical :',
        'select_canonical' => '- Pilih Canonical -',
        'feature_image' => 'Gambar Fitur :',
        'is_publish' => 'Apakah sudah terpublikasi ?'
    ],

    'detail' => [
        'title' => 'Judul :',
        'feature_image' => 'Gambar Fitur : ',
        'slug' => 'Slug :',
        'content' => 'Konten :',
        'category' => 'Kategori',
        'tags' => 'Tag',
        'meta' => 'SEO Meta',
        'canonical' => 'SEO Canonical',
        'is_published' => 'Apakah sudah terpublikasi?',
    ],

    'messages' => [
        'store_success' => 'Sukses menyimpan post',
        'store_failed' => 'Gagal menyimpan pos',
        'update_success' => 'Sukses memperbarui pos',
        'update_failed' => 'Gagal memperbarui pos',
        'ask_delete' => 'Apakah yakin menghapus post ini?',
        'delete_success' => 'Sukses menghapus post',
        'delete_failed' => 'Gagal menghapus post',
        'image_not_available' => 'Gambar tidak tersedia',
    ],

    'validation' => [
        'title_required' => 'Judul wajib diisi',
        'content_required' => 'Konten wajib diisi',
        'feature_image_required' => 'Gambar wajib diisi',
    ],
];
