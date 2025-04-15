<?php

// lang/id/backend/section.php
return [
    'title' => 'Bagian', // Ganti Komponen -> Bagian
    'breadcrumb' => [
        'title' => 'Bagian', // Ganti Komponen -> Bagian
        'home' => 'Beranda',
        'index' => 'Halaman Indeks',
        'create' => 'Halaman Buat',
        'edit' => 'Halaman Edit',
    ],
    'datatable' => [
        'header' => [
            'title' => 'Manajemen Bagian', // Ganti Komponen -> Bagian
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Nama',
            'description' => 'Deskripsi',
            'layout_type' => 'Tipe Tata Letak',
            'column_layout' => 'Kolom', // Diubah
            'status' => 'Status',
            'action' => 'Aksi',
        ],
        'search' => 'Cari: ',
        'previous' => 'Sebelumnya',
        'next' => 'Selanjutnya',
        'info' => 'Menampilkan _START_ hingga _END_ dari _TOTAL_ entri',
        'length_menu' => 'Tampilkan _MENU_ entri',
        'status_active' => 'Aktif',
        'status_inactive' => 'Tidak Aktif',
    ],
    'form' => [
        'create_title' => 'Buat Bagian', // Ganti Komponen -> Bagian
        'edit_title' => 'Edit Bagian', // Ganti Komponen -> Bagian
        'name' => 'Nama :',
        'name_placeholder' => 'Masukkan nama bagian...', // Ganti komponen -> bagian
        'description' => 'Deskripsi :',
        'description_placeholder' => 'Masukkan deskripsi (opsional)...',
        'layout_type' => 'Tipe Tata Letak :', // Tambahkan
        'select_layout_type' => 'Pilih Tipe Tata Letak...', // Tambahkan
        'column_layout' => 'Tata Letak Kolom :', // Diubah
        'select_column_layout' => 'Pilih tata letak kolom...', // Diubah
        'layout_options' => 'Opsi Tata Letak :', // Tambahkan
        'layout_options_placeholder' => 'cth: row-cols-md-3 g-4 atau d-flex justify-content-between (opsional)...', // Tambahkan
        'is_active' => 'Status Aktif',
        'select_components' => 'Pilih Komponen...', // Ganti Gambar -> Komponen
        'selected_components' => 'Komponen Terpilih (Seret untuk Mengurutkan)', // Ganti Gambar -> Komponen
    ],
    'messages' => [
        'store_success' => 'Bagian berhasil disimpan', // Ganti Komponen -> Bagian
        'store_failed' => 'Bagian gagal disimpan', // Ganti Komponen -> Bagian
        'update_success' => 'Bagian berhasil diperbarui', // Ganti Komponen -> Bagian
        'update_failed' => 'Bagian gagal diperbarui', // Ganti Komponen -> Bagian
        'delete_success' => 'Bagian berhasil dihapus', // Ganti Komponen -> Bagian
        'delete_failed' => 'Bagian gagal dihapus', // Ganti Komponen -> Bagian
        'ask_delete' => 'Apakah Anda yakin ingin menghapus Bagian ini?', // Ganti Komponen -> Bagian
        'not_found' => 'Bagian tidak ditemukan.', // Ganti Komponen -> Bagian
        'select_item_first' => 'Silakan pilih setidaknya satu item terlebih dahulu!',
        'ask_bulk_delete' => 'Apakah Anda yakin ingin menghapus item yang dipilih?',
        'bulk_delete_warning' => 'Anda tidak akan dapat mengembalikan tindakan ini!',
        'bulk_delete_success' => 'Item yang dipilih berhasil dihapus', // Pesan umum
        'bulk_delete_success_count' => '{count} item berhasil dihapus.', // Pesan dengan count
        'bulk_delete_failed' => 'Gagal menghapus item yang dipilih',
        'none_deleted' => 'Tidak ada item yang cocok ditemukan atau dihapus.',
        'update_failed_not_found' => 'Bagian tidak ditemukan atau gagal diperbarui.', // Pesan spesifik update
        'delete_failed_not_found' => 'Gagal menghapus bagian (tidak ditemukan)', // Pesan spesifik delete
    ],
    'validation' => [
        // Rules dasar
        'name_required' => 'Kolom nama wajib diisi.',
        'name_string' => 'Nama harus berupa teks.',
        'name_max' => 'Nama tidak boleh lebih dari 255 karakter.',
        'name_unique' => 'Nama ini sudah digunakan.',
        'description_string' => 'Deskripsi harus berupa teks.',
        'layout_type_required' => 'Kolom tipe tata letak wajib diisi.', // Tambahkan
        'layout_type_string' => 'Tipe tata letak harus berupa teks.', // Tambahkan
        'layout_type_max' => 'Tipe tata letak tidak boleh lebih dari 50 karakter.', // Tambahkan
        'layout_options_string' => 'Opsi tata letak harus berupa teks.', // Tambahkan
        'layout_options_max' => 'Opsi tata letak tidak boleh lebih dari 1000 karakter.', // Tambahkan
        'is_active_required' => 'Kolom status aktif wajib diisi.',
        'is_active_boolean' => 'Status aktif harus berupa benar atau salah.',

        // Rules untuk components_order
        'components_order_array' => 'Data urutan komponen harus disusun sebagai array.', // Ganti gambar -> komponen

        // Rules untuk bulk delete
        'ids_required' => 'Kolom pilihan wajib diisi.',
        'ids_array' => 'Pilihan harus berupa array.',
        'ids_item_required' => 'Setiap ID item yang dipilih wajib diisi.',
        'ids_item_uuid' => 'Setiap item yang dipilih harus berupa UUID yang valid.',
        'ids_item_exists' => 'Satu atau lebih item yang dipilih tidak ada di database.',
    ],
    // Definisikan teks display untuk layout kolom (opsional, bisa juga dibuat di controller)
    'layout_types' => [
        '1-column' => '1 Kolom',
        '2-column' => '2 Kolom',
        '3-column' => '3 Kolom',
        '4-column' => '4 Kolom',
        '5-column' => '5 Kolom',
        '6-column' => '6 Kolom',
        '7-column' => '7 Kolom',
        '8-column' => '8 Kolom',
        '9-column' => '9 Kolom',
        '10-column' => '10 Kolom',
        '11-column' => '11 Kolom',
        '12-column' => '12 Kolom',
    ],
];
