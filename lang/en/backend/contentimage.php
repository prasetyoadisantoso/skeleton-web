<?php

return [
    'title' => 'Content Images', // Ganti
    'breadcrumb' => [
        'title' => 'Content Images', // Ganti
        'home' => 'Home',
        'index' => 'Index Page',
        'create' => 'Create Page',
        'edit' => 'Edit Page',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Content Image Management', // Ganti
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Name',
            'image' => 'Image', // Ganti
            'alt_text' => 'Alt Text', // Baru
            'caption' => 'Caption', // Baru
            'action' => 'Action',
        ],
        'search' => 'Search: ',
        'previous' => 'Previous',
        'next' => 'Next',
        'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
        'length_menu' => 'Show _MENU_ entries',
    ],

    'form' => [
        'create_title' => 'Create Content Image', // Ganti
        'edit_title' => 'Edit Content Image', // Ganti
        'alt_text' => 'Alt Text :', // Baru
        'alt_text_placeholder' => 'Insert alt text...', // Baru
        'caption' => 'Caption :', // Baru
        'caption_placeholder' => 'Insert caption (optional)...', // Baru
        'media_file' => 'Image File :', // Ganti
        'media_file_note' => 'Allowed types: jpg, jpeg, png, webp, gif. Max 5MB.', // Baru
        'current_image' => 'Current Image:', // Baru
    ],

    // 'button' => [ // Jika belum ada struktur ini, buatlah
    //     'delete_selected' => 'Delete Selected', // Tombol Bulk Delete
    //     'ok' => 'OK', // Tombol OK untuk alert info
    //     'confirm_delete' => 'Yes, delete them!', // Konfirmasi bulk delete
    // ],

    'messages' => [
        'store_success' => 'Content Image stored successfully', // Ganti
        'store_failed' => 'Content Image failed to store', // Ganti
        'update_success' => 'Content Image updated successfully', // Ganti
        'update_failed' => 'Content Image failed to update', // Ganti
        'delete_success' => 'Content Image deleted successfully', // Ganti
        'delete_failed' => 'Content Image failed to delete', // Ganti
        'ask_delete' => 'Do you want to delete this Content Image?', // Ganti
        'not_found' => 'Content Image not found.', // Baru
        'image_not_available' => 'Image not available', // Baru atau sesuaikan
        'select_item_first' => 'Please select at least one item first!', // Pesan jika tidak ada yg dipilih
        'ask_bulk_delete' => 'Are you sure you want to delete the selected items?', // Konfirmasi bulk
        'bulk_delete_warning' => "You won't be able to revert this!", // Warning bulk
        'bulk_delete_success' => 'Selected items deleted successfully', // Sukses bulk
        'bulk_delete_failed' => 'Failed to delete selected items', // Gagal bulk
        'none_deleted' => 'No matching items found or deleted.', // Jika tidak ada yg terhapus
    ],

    'validation' => [
        'media_file_required' => 'The image file is required.',
        'media_file_image' => 'The file must be an image.',
        'media_file_mimes' => 'The image must be a file of type: jpg, jpeg, png, webp, gif.',
        'media_file_max' => 'The image may not be greater than 5MB.',
        'alt_text_required' => 'The alt text is required.',
        'alt_text_max' => 'The alt text may not be greater than 255 characters.',
        'caption_max' => 'The caption may not be greater than 1000 characters.',
        'ids_required' => 'The selection field is required.', // EN
        'ids_array' => 'The selection must be an array.', // EN
        'ids_item_required' => 'Each selected item ID is required.', // EN
        'ids_item_uuid' => 'Each selected item must be a valid identifier.', // EN
    ],
];
