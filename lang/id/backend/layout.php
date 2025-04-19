<?php

return [
    'title' => 'Tata Letak',
    'breadcrumb' => [
        'title' => 'Tata Letak',
        'home' => 'Beranda',
        'index' => 'Halaman Indeks',
        'create' => 'Halaman Buat',
        'edit' => 'Halaman Edit',
    ],
    'datatable' => [
        'header' => [
            'title' => 'Manajemen Tata Letak',
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Nama',
            'type' => 'Jenis',
            'action' => 'Aksi',
        ],
        'search' => 'Cari: ',
        'previous' => 'Sebelumnya',
        'next' => 'Selanjutnya',
        'info' => 'Menampilkan _START_ hingga _END_ dari _TOTAL_ entri',
        'length_menu' => 'Tampilkan _MENU_ entri',
    ],
    'form' => [
        'create_title' => 'Buat Tata Letak',
        'edit_title' => 'Edit Tata Letak',
        'name' => 'Nama:',
        'name_placeholder' => 'Masukkan nama tata letak...',
        'type' => 'Jenis:',
        'section_main' => 'Bagian Utama',
        'section_sidebar' => 'Bagian Sidebar',
        'add_section' => 'Tambahkan Bagian',
        'remove_section' => 'Hapus Bagian',
        'section_order' => 'Urutan Bagian'
    ],
    'messages' => [
        'store_success' => 'Tata letak berhasil dibuat.',
        'store_failed' => 'Tata letak gagal dibuat.',
        'update_success' => 'Tata letak berhasil diperbarui.',
        'update_failed' => 'Tata letak gagal diperbarui.',
        'delete_success' => 'Tata letak berhasil dihapus.',
        'delete_failed' => 'Tata letak gagal dihapus.',
        'ask_delete' => 'Anda yakin ingin menghapus tata letak ini?',
        'ask_bulk_delete' => 'Anda yakin ingin menghapus tata letak ini?',
        'no_section_selected' => 'Tidak ada bagian yang dipilih.',
        'store_section_failed' => 'Gagal menyimpan bagian.',
        'update_section_failed' => 'Gagal memperbarui bagian.',
        'delete_section_success' => 'Bagian berhasil dihapus.',
        'delete_section_failed' => 'Gagal menghapus bagian.',
        'select_item_first' => 'Silakan pilih setidaknya satu item terlebih dahulu!',
    ],
    'validation' => [
        'name_required' => 'Kolom nama wajib diisi.',
        'name_string' => 'Nama harus berupa teks.',
        'name_max' => 'Nama tidak boleh lebih dari 255 karakter.',
        'name_unique' => 'Nama ini sudah digunakan.',
        'type_required' => 'Kolom jenis wajib diisi.',
        'type_in' => 'Jenis yang dipilih tidak valid.',
        'sections_required' => 'Bagian harus disediakan.',
    ],
    'layout_types' => [
        'full-width' => 'Lebar Penuh',
        'sidebar' => 'Sidebar',
    ],
];
