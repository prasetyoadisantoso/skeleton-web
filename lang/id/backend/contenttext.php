<?php
// lang/id/backend/contenttext.php
return [
    'title' => "Teks Konten",
    'breadcrumb' => [
        'title' => 'Teks Konten',
        'home' => 'Beranda',
        'index' => 'Halaman Indeks',
        'create' => 'Halaman Buat',
        'edit' => 'Halaman Edit',
    ],
    'datatable' => [
        'header' => [
            'title' => 'Manajemen Teks Konten',
        ],
        'table' => [
            'number' => 'No',
            'type' => 'Tipe', // Baru
            'content' => 'Konten', // Baru
            'action' => 'Aksi',
        ],
        'search' => 'Cari: ',
        'previous' => 'Sebelumnya',
        'next' => 'Selanjutnya',
        'info' => "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
        'length_menu' => 'Tampilkan _MENU_ entri',
    ],
    'form' => [
        'create_title' => 'Buat Teks Konten',
        'edit_title' => 'Edit Teks Konten',
        'type' => 'Tipe :', // Baru
        'select_type' => 'Pilih Tipe...', // Baru
        'content' => 'Konten :', // Baru
        'content_placeholder' => 'Masukkan konten teks...', // Baru
    ],
    'messages' => [
        'store_success' => 'Teks Konten berhasil disimpan',
        'store_failed' => 'Teks Konten gagal disimpan',
        'update_success' => 'Teks Konten berhasil diperbarui',
        'update_failed' => 'Teks Konten gagal diperbarui',
        'delete_success' => 'Teks Konten berhasil dihapus',
        'delete_failed' => 'Teks Konten gagal dihapus',
        'ask_delete' => 'Apakah Anda ingin menghapus Teks Konten ini?',
        'not_found' => 'Teks Konten tidak ditemukan.',
        'select_item_first' => 'Silakan pilih setidaknya satu item terlebih dahulu!',
        'ask_bulk_delete' => 'Apakah Anda yakin ingin menghapus item yang dipilih?',
        'bulk_delete_warning' => 'Anda tidak akan dapat mengembalikan tindakan ini!',
        'bulk_delete_success' => 'Item yang dipilih berhasil dihapus',
        'bulk_delete_failed' => 'Gagal menghapus item yang dipilih',
        'none_deleted' => 'Tidak ada item yang cocok ditemukan atau dihapus.',
    ],
    'validation' => [
        'type_required' => 'Kolom tipe wajib diisi.',
        'type_string' => 'Tipe harus berupa string.',
        'type_in' => 'Tipe yang dipilih tidak valid.',
        'content_required' => 'Kolom konten wajib diisi.',
        'content_string' => 'Konten harus berupa string.',
        // 'content_max' => 'Konten tidak boleh lebih dari :max karakter.',
        'ids_required' => 'Kolom pilihan wajib diisi.',
        'ids_array' => 'Pilihan harus berupa array.',
        'ids_item_required' => 'Setiap ID item yang dipilih wajib diisi.',
        'ids_item_uuid' => 'Setiap item yang dipilih harus merupakan pengidentifikasi yang valid.',
    ],
];
