<?php

// lang/id/backend/contentimage.php

return [
    'title' => 'Gambar Konten', // Ganti
    'breadcrumb' => [
        'title' => 'Gambar Konten', // Ganti
        'home' => 'Beranda',
        'index' => 'Halaman Index',
        'create' => 'Halaman Buat',
        'edit' => 'Halaman Edit',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Manajemen Gambar Konten', // Ganti
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Nama',
            'image' => 'Gambar', // Ganti
            'alt_text' => 'Teks Alt', // Baru
            'caption' => 'Keterangan', // Baru
            'action' => 'Aksi',
        ],
        'search' => 'Cari: ',
        'previous' => 'Sebelumnya',
        'next' => 'Selanjutnya',
        'info' => 'Menampilkan _START_ hingga _END_ dari _TOTAL_ entri',
        'length_menu' => 'Tampilkan _MENU_ entri',
    ],

    'form' => [
        'create_title' => 'Buat Gambar Konten', // Ganti
        'edit_title' => 'Edit Gambar Konten', // Ganti
        'alt_text' => 'Teks Alt :', // Baru
        'alt_text_placeholder' => 'Masukkan teks alt...', // Baru
        'caption' => 'Keterangan :', // Baru
        'caption_placeholder' => 'Masukkan keterangan (opsional)...', // Baru
        'media_file' => 'File Gambar :', // Ganti
        'media_file_note' => 'Tipe yang diizinkan: jpg, jpeg, png, webp, gif. Maks 5MB.', // Baru
        'current_image' => 'Gambar Saat Ini:', // Baru
    ],

    // 'button' => [ // Tambahkan section ini
    //     'delete_selected' => 'Hapus yang Dipilih',
    //     'ok' => 'OK',
    //     'confirm_delete' => 'Ya, hapus!', // Atau sesuaikan dengan tombol konfirmasi lain
    // ],

    'messages' => [
        'store_success' => 'Gambar Konten berhasil disimpan', // Ganti
        'store_failed' => 'Gambar Konten gagal disimpan', // Ganti
        'update_success' => 'Gambar Konten berhasil diperbarui', // Ganti
        'update_failed' => 'Gambar Konten gagal diperbarui', // Ganti
        'delete_success' => 'Gambar Konten berhasil dihapus', // Ganti
        'delete_failed' => 'Gambar Konten gagal dihapus', // Ganti
        'ask_delete' => 'Apakah Anda yakin ingin menghapus Gambar Konten ini?', // Ganti
        'not_found' => 'Gambar Konten tidak ditemukan.', // Baru
        'image_not_available' => 'Gambar tidak tersedia', // Baru atau sesuaikan
        'select_item_first' => 'Silakan pilih setidaknya satu item terlebih dahulu!', // Tambahkan
        'ask_bulk_delete' => 'Apakah Anda yakin ingin menghapus item yang dipilih?', // Tambahkan
        'bulk_delete_warning' => 'Anda tidak akan dapat mengembalikan tindakan ini!', // Tambahkan
        'bulk_delete_success' => 'Item yang dipilih berhasil dihapus', // Tambahkan
        'bulk_delete_failed' => 'Gagal menghapus item yang dipilih', // Tambahkan
        'none_deleted' => 'Tidak ada item yang cocok ditemukan atau dihapus.', // Tambahkan
    ],

    'validation' => [
        'media_file_required' => 'File gambar wajib diisi.',
        'media_file_image' => 'File harus berupa gambar.',
        'media_file_mimes' => 'Gambar harus berupa file dengan tipe: jpg, jpeg, png, webp, gif.',
        'media_file_max' => 'Ukuran gambar tidak boleh lebih besar dari 5MB.', // Disesuaikan agar lebih user-friendly
        'alt_text_required' => 'Teks alt wajib diisi.',
        'alt_text_max' => 'Teks alt tidak boleh lebih dari 255 karakter.',
        'caption_max' => 'Keterangan tidak boleh lebih dari 1000 karakter.',
        'ids_required' => 'Kolom pilihan wajib diisi.', // ID
        'ids_array' => 'Pilihan harus berupa array.', // ID
        'ids_item_required' => 'Setiap ID item yang dipilih wajib diisi.', // ID
        'ids_item_uuid' => 'Setiap item yang dipilih harus berupa identifier yang valid.', // ID
    ],
];
