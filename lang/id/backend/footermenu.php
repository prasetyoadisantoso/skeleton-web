<?php

return [
    'title' => 'Menu Footer',
    'breadcrumb' => [
        'title' => 'Pengaturan Menu Footer',
        'home' => 'Beranda',
        'index' => 'Halaman Index',
        'create' => 'Halaman Pembuatan',
        'edit' => 'Halaman Edit',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Manajemen Menu Footer',
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Nama',
            'label' => 'Label',
            'url' => 'URL',
            'parent' => 'Parent',
            'order' => 'Urutan',
            'target' => 'Target',
            'status' => 'Status',
            'action' => 'Aksi',
        ],
        'search' => 'Cari: ',
        'previous' => 'Sebelumnya',
        'next' => 'Selanjutnya',
        'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
        'length_menu' => 'Tampilkan _MENU_ entri',
    ],

    'form' => [
        'create_title' => 'Buat Menu Footer',
        'edit_title' => 'Edit Menu Footer',
        'name' => 'Nama :',
        'name_placeholder' => 'Masukkan nama menu...',
        'name_help' => 'Nama unik untuk identifikasi internal.', // New
        'label' => 'Label :',
        'label_placeholder' => 'Masukkan label...',
        'label_help' => 'Teks yang ditampilkan di menu.', // New
        'url' => 'URL :',
        'url_placeholder' => 'Masukkan URL...',
        'url_help' => 'URL tujuan (bisa eksternal atau internal).', // New
        'icon' => 'Ikon :',
        'icon_placeholder' => 'Masukkan kelas ikon...',
        'icon_help' => 'Kelas CSS untuk ikon (contoh: FontAwesome).', // New
        'parent' => 'Menu Parent :',
        'parent_placeholder' => '- Tingkat Atas -', // Updated text
        'parent_help' => 'Pilih menu parent jika ini adalah submenu.', // New
        'order' => 'Urutan :',
        'order_placeholder' => 'Masukkan nomor urutan...',
        'order_help' => 'Urutan menu ditampilkan.', // New
        'target' => 'Target :',
        'target_placeholder' => 'Masukkan target...',
        'target_self' => '_self (Tab Sama)', // New
        'target_blank' => '_blank (Tab Baru)', // New
        'target_help' => 'Target untuk tautan menu.', // New
        'status' => 'Status :', // Keep or remove
        'status_placeholder' => 'Atur status...', // Keep or remove
        'active_label' => 'Aktif', // New for checkbox label
    ],

    'messages' => [
        'store_success' => 'Menu Footer berhasil disimpan',
        'store_failed' => 'Menu Footer gagal disimpan',
        'update_success' => 'Menu Footer berhasil diperbarui',
        'update_failed' => 'Menu Footer gagal diperbarui',
        'ask_delete' => 'Apakah Anda ingin menghapus Menu Footer ini?',
        'delete_success' => 'Menu Footer berhasil dihapus',
        'delete_failed' => 'Menu Footer gagal dihapus',
    ],

    'validation' => [
        'name_required' => 'Nama menu wajib diisi',
        'label_required' => 'Label wajib diisi',
        'order_required' => 'Urutan wajib diisi',
    ],
];
