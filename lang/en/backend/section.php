<?php

// lang/en/backend/section.php
return [
    'title' => 'Sections', // Ganti Component -> Section
    'breadcrumb' => [
        'title' => 'Sections', // Ganti Component -> Section
        'home' => 'Home',
        'index' => 'Index Page',
        'create' => 'Create Page',
        'edit' => 'Edit Page',
    ],
    'datatable' => [
        'header' => [
            'title' => 'Section Management', // Ganti Component -> Section
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Name',
            'description' => 'Description',
            'layout_type' => 'Layout Type', // Tambahkan
            'column_layout' => 'Columns', // Diubah
            'status' => 'Status',
            'action' => 'Action',
        ],
        'search' => 'Search: ',
        'previous' => 'Previous',
        'next' => 'Next',
        'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
        'length_menu' => 'Show _MENU_ entries',
        'status_active' => 'Active',
        'status_inactive' => 'Inactive',
    ],
    'form' => [
        'create_title' => 'Create Section', // Ganti Component -> Section
        'edit_title' => 'Edit Section', // Ganti Component -> Section
        'name' => 'Name :',
        'name_placeholder' => 'Insert section name...', // Ganti component -> section
        'description' => 'Description :',
        'description_placeholder' => 'Insert description (optional)...',
        'layout_type' => 'Layout Type :', // Tambahkan
        'select_layout_type' => 'Select Layout Type...', // Tambahkan
        'column_layout' => 'Column Layout :', // Diubah
        'select_column_layout' => 'Select column layout...', // Diubah
        'layout_options' => 'Layout Options :', // Tambahkan
        'layout_options_placeholder' => 'e.g., row-cols-md-3 g-4 or d-flex justify-content-between (optional)...', // Tambahkan
        'is_active' => 'Active Status',
        'select_components' => 'Select Components...', // Ganti Images -> Components
        'selected_components' => 'Selected Components (Drag to Reorder)', // Ganti Images -> Components
    ],
    'messages' => [
        'store_success' => 'Section stored successfully', // Ganti Component -> Section
        'store_failed' => 'Section failed to store', // Ganti Component -> Section
        'update_success' => 'Section updated successfully', // Ganti Component -> Section
        'update_failed' => 'Section failed to update', // Ganti Component -> Section
        'delete_success' => 'Section deleted successfully', // Ganti Component -> Section
        'delete_failed' => 'Section failed to delete', // Ganti Component -> Section
        'ask_delete' => 'Do you want to delete this Section?', // Ganti Component -> Section
        'not_found' => 'Section not found.', // Ganti Component -> Section
        'select_item_first' => 'Please select at least one item first!',
        'ask_bulk_delete' => 'Are you sure you want to delete the selected items?',
        'bulk_delete_warning' => 'You won\'t be able to revert this!',
        'bulk_delete_success' => 'Selected items deleted successfully', // Pesan umum
        'bulk_delete_success_count' => '{count} items deleted successfully.', // Pesan dengan count
        'bulk_delete_failed' => 'Failed to delete selected items',
        'none_deleted' => 'No matching items found or deleted.',
        'update_failed_not_found' => 'Section not found or failed to update.', // Pesan spesifik update
        'delete_failed_not_found' => 'Failed to delete section (not found)', // Pesan spesifik delete
    ],
    'validation' => [
        // Rules dasar
        'name_required' => 'The name field is required.',
        'name_string' => 'The name must be a string.',
        'name_max' => 'The name may not be greater than 255 characters.',
        'name_unique' => 'This name has already been taken.',
        'description_string' => 'The description must be a string.',
        'layout_type_required' => 'The layout type field is required.', // Tambahkan
        'layout_type_string' => 'The layout type must be a string.', // Tambahkan
        'layout_type_max' => 'The layout type may not be greater than 50 characters.', // Tambahkan
        'layout_options_string' => 'The layout options must be a string.', // Tambahkan
        'layout_options_max' => 'The layout options may not be greater than 1000 characters.', // Tambahkan
        'is_active_required' => 'The active status field is required.',
        'is_active_boolean' => 'The active status must be true or false.',

        // Rules untuk components_order
        'components_order_array' => 'The components order data must be structured as an array.', // Ganti images -> components

        // Rules untuk bulk delete
        'ids_required' => 'The selection field is required.',
        'ids_array' => 'The selection must be an array.',
        'ids_item_required' => 'Each selected item ID is required.',
        'ids_item_uuid' => 'Each selected item must be a valid identifier.',
        'ids_item_exists' => 'One or more selected items do not exist.',
    ],
    'layout_types' => [
        '1-column' => '1 Column',
        '2-column' => '2 Columns',
        '3-column' => '3 Columns',
        '4-column' => '4 Columns',
        '5-column' => '5 Columns',
        '6-column' => '6 Columns',
        '7-column' => '7 Columns',
        '8-column' => '8 Columns',
        '9-column' => '9 Columns',
        '10-column' => '10 Columns',
        '11-column' => '11 Columns',
        '12-column' => '12 Columns',
    ],
];
