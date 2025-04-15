<?php

// lang/id/backend/component.php
return [
    'title' => 'Komponen',
    'breadcrumb' => [
        'title' => 'Komponen',
        'home' => 'Beranda',
        'index' => 'Halaman Indeks', // Atau 'Halaman Daftar'
        'create' => 'Halaman Buat',
        'edit' => 'Halaman Edit',
    ],
    'datatable' => [
        'header' => [
            'title' => 'Manajemen Komponen',
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Nama',
            'description' => 'Deskripsi',
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
        'create_title' => 'Buat Komponen',
        'edit_title' => 'Edit Komponen',
        'name' => 'Nama :',
        'name_placeholder' => 'Masukkan nama komponen...',
        'description' => 'Deskripsi :',
        'description_placeholder' => 'Masukkan deskripsi (opsional)...',
        'is_active' => 'Status Aktif',
        'select_content_images' => 'Pilih Gambar...', // Uncomment or add
        'selected_content_images' => 'Gambar Terpilih (Seret untuk Mengurutkan)', // New
        'selected_content_texts' => 'Teks Terpilih (Seret untuk Mengurutkan)', // <-- New
    ],
    'button' => [
        'delete_selected' => 'Hapus yang Dipilih',
        'confirm_delete' => 'Ya, hapus!',
        'cancel_delete' => 'Batal',
        'ok' => 'OK',
    ],
    'messages' => [
        'store_success' => 'Komponen berhasil disimpan',
        'store_failed' => 'Komponen gagal disimpan',
        'update_success' => 'Komponen berhasil diperbarui',
        'update_failed' => 'Komponen gagal diperbarui',
        'delete_success' => 'Komponen berhasil dihapus',
        'delete_failed' => 'Komponen gagal dihapus',
        'ask_delete' => 'Apakah Anda yakin ingin menghapus Komponen ini?',
        'not_found' => 'Komponen tidak ditemukan.',
        'select_item_first' => 'Silakan pilih setidaknya satu item terlebih dahulu!',
        'ask_bulk_delete' => 'Apakah Anda yakin ingin menghapus item yang dipilih?',
        'bulk_delete_warning' => 'Anda tidak akan dapat mengembalikan tindakan ini!',
        'bulk_delete_success' => 'Item yang dipilih berhasil dihapus',
        'bulk_delete_failed' => 'Gagal menghapus item yang dipilih',
        'none_deleted' => 'Tidak ada item yang cocok ditemukan atau dihapus.',
    ],
    'validation' => [
        'name_required' => 'Kolom nama wajib diisi.',
        'name_string' => 'Nama harus berupa teks.',
        'name_max' => 'Nama tidak boleh lebih dari 255 karakter.',
        'description_string' => 'Deskripsi harus berupa teks.',
        'is_active_in' => 'Nilai status aktif tidak valid.',
        'content_images_order_json' => 'Data urutan gambar konten harus berupa string JSON yang valid.',
        'ids_required' => 'Kolom pilihan wajib diisi.',
        'ids_array' => 'Pilihan harus berupa array.',
        'ids_item_required' => 'Setiap ID item yang dipilih wajib diisi.',
        'ids_item_uuid' => 'Setiap item yang dipilih harus berupa identifier yang valid.',
        'ids_item_exists' => 'Satu atau lebih item yang dipilih tidak ada.',
        'is_active_required' => 'Kolom status aktif wajib diisi.',
        'is_active_boolean' => 'Status aktif harus berupa benar atau salah.',
        'content_images_order_array' => 'Data urutan gambar konten harus disusun sebagai array.',
        'content_texts_order_array' => 'Data urutan teks konten harus disusun sebagai array.', // <-- New
    ],
];
