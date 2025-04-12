<?php
// lang/en/backend/contenttext.php
return [
    'title' => "Content Texts",
    'breadcrumb' => [
        'title' => 'Content Texts',
        'home' => 'Home',
        'index' => 'Index Page',
        'create' => 'Create Page',
        'edit' => 'Edit Page',
    ],
    'datatable' => [
        'header' => [
            'title' => 'Content Text Management',
        ],
        'table' => [
            'number' => 'No',
            'type' => 'Type', // Baru
            'content' => 'Content', // Baru
            'action' => 'Action',
        ],
        'search' => 'Search: ',
        'previous' => 'Previous',
        'next' => 'Next',
        'info' => "Showing _START_ to _END_ of _TOTAL_ entries",
        'length_menu' => 'Show _MENU_ entries',
    ],
    'form' => [
        'create_title' => 'Create Content Text',
        'edit_title' => 'Edit Content Text',
        'type' => 'Type :', // Baru
        'select_type' => 'Select Type...', // Baru
        'content' => 'Content :', // Baru
        'content_placeholder' => 'Insert text content...', // Baru
    ],
    'messages' => [
        'store_success' => 'Content Text stored successfully',
        'store_failed' => 'Content Text failed to store',
        'update_success' => 'Content Text updated successfully',
        'update_failed' => 'Content Text failed to update',
        'delete_success' => 'Content Text deleted successfully',
        'delete_failed' => 'Content Text failed to delete',
        'ask_delete' => 'Do you want to delete this Content Text?',
        'not_found' => 'Content Text not found.',
        'select_item_first' => 'Please select at least one item first!',
        'ask_bulk_delete' => 'Are you sure you want to delete the selected items?',
        'bulk_delete_warning' => 'You won\'t be able to revert this!',
        'bulk_delete_success' => 'Selected items deleted successfully',
        'bulk_delete_failed' => 'Failed to delete selected items',
        'none_deleted' => 'No matching items found or deleted.',
    ],
    'validation' => [
        'type_required' => 'The type field is required.',
        'type_string' => 'The type must be a string.',
        'type_in' => 'The selected type is invalid.',
        'content_required' => 'The content field is required.',
        'content_string' => 'The content must be a string.',
        // 'content_max' => 'The content may not be greater than :max characters.',
        'ids_required' => 'The selection field is required.',
        'ids_array' => 'The selection must be an array.',
        'ids_item_required' => 'Each selected item ID is required.',
        'ids_item_uuid' => 'Each selected item must be a valid identifier.',
    ],
];
