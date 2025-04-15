<?php

// lang/en/backend/component.php
return [
    'title' => 'Components',
    'breadcrumb' => [
        'title' => 'Components',
        'home' => 'Home',
        'index' => 'Index Page',
        'create' => 'Create Page',
        'edit' => 'Edit Page',
    ],
    'datatable' => [
        'header' => [
            'title' => 'Component Management',
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Name',
            'description' => 'Description',
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
        'create_title' => 'Create Component',
        'edit_title' => 'Edit Component',
        'name' => 'Name :',
        'name_placeholder' => 'Insert component name...',
        'description' => 'Description :',
        'description_placeholder' => 'Insert description (optional)...',
        'is_active' => 'Active Status',
        'select_content_images' => 'Select Images...', // Uncomment or add
        'selected_content_images' => 'Selected Images (Drag to Reorder)', // New
        'selected_content_texts' => 'Selected Texts (Drag to Reorder)', // <-- New
    ],
    'button' => [
        'delete_selected' => 'Delete Selected',
        'confirm_delete' => 'Yes, delete it!',
        'cancel_delete' => 'Cancel',
        'ok' => 'OK',
    ],
    'messages' => [
        'store_success' => 'Component stored successfully',
        'store_failed' => 'Component failed to store',
        'update_success' => 'Component updated successfully',
        'update_failed' => 'Component failed to update',
        'delete_success' => 'Component deleted successfully',
        'delete_failed' => 'Component failed to delete',
        'ask_delete' => 'Do you want to delete this Component?',
        'not_found' => 'Component not found.',
        'select_item_first' => 'Please select at least one item first!',
        'ask_bulk_delete' => 'Are you sure you want to delete the selected items?',
        'bulk_delete_warning' => 'You won\'t be able to revert this!',
        'bulk_delete_success' => 'Selected items deleted successfully',
        'bulk_delete_failed' => 'Failed to delete selected items',
        'none_deleted' => 'No matching items found or deleted.',
    ],
    'validation' => [
        'name_required' => 'The name field is required.',
        'name_string' => 'The name must be a string.',
        'name_max' => 'The name may not be greater than 255 characters.',
        'description_string' => 'The description must be a string.',
        'is_active_in' => 'Invalid value for active status.',
        'content_images_order_json' => 'The content images order data must be a valid JSON string.',
        'ids_required' => 'The selection field is required.',
        'ids_array' => 'The selection must be an array.',
        'ids_item_required' => 'Each selected item ID is required.',
        'ids_item_uuid' => 'Each selected item must be a valid identifier.',
        'ids_item_exists' => 'One or more selected items do not exist.',
        'is_active_required' => 'The active status field is required.',
        'is_active_boolean' => 'The active status must be true or false.',
        'content_images_order_array' => 'The content images order data must be structured as an array.',
        'content_texts_order_array' => 'The content texts order data must be structured as an array.',
    ],
];
