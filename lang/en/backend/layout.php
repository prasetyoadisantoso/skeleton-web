<?php

return [
    'title' => 'Layouts',
    'breadcrumb' => [
        'title' => 'Layouts',
        'home' => 'Home',
        'index' => 'Index Page',
        'create' => 'Create Page',
        'edit' => 'Edit Page',
    ],
    'datatable' => [
        'header' => [
            'title' => 'Layout Management',
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Name',
            'type' => 'Type',
            'action' => 'Action',
        ],
        'search' => 'Search: ',
        'previous' => 'Previous',
        'next' => 'Next',
        'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
        'length_menu' => 'Show _MENU_ entries',
    ],
    'form' => [
        'create_title' => 'Create Layout',
        'edit_title' => 'Edit Layout',
        'name' => 'Name:',
        'name_placeholder' => 'Insert layout name...',
        'type' => 'Type:',
        'section_main' => 'Main Sections',
        'section_sidebar' => 'Sidebar Sections',
        'add_section' => 'Add Section',
        'remove_section' => 'Remove Section',
        'section_order' => 'Section Order'
    ],
    'messages' => [
        'store_success' => 'Layout created successfully.',
        'store_failed' => 'Failed to create layout.',
        'update_success' => 'Layout updated successfully.',
        'update_failed' => 'Failed to update layout.',
        'delete_success' => 'Layout deleted successfully.',
        'delete_failed' => 'Failed to delete layout.',
        'ask_delete' => 'Are you sure you want to delete this layout?',
        'ask_bulk_delete' => 'Are you sure you want to delete these layouts?',
        'no_section_selected' => 'No section selected.',
        'store_section_failed' => 'Failed to store section.',
        'update_section_failed' => 'Failed to update section.',
        'delete_section_success' => 'Section deleted successfully.',
        'delete_section_failed' => 'Failed to delete section.',
        'select_item_first' => 'Please select at least one item first!',
    ],
    'validation' => [
        'name_required' => 'The name field is required.',
        'name_string' => 'The name must be a string.',
        'name_max' => 'The name may not be greater than 255 characters.',
        'name_unique' => 'This name has already been taken.',
        'type_required' => 'The type field is required.',
        'type_in' => 'The selected type is invalid.',
        'sections_required' => 'Sections must be provided.',
    ],
    'layout_types' => [
        'full-width' => 'Full Width',
        'sidebar' => 'Sidebar',
    ],
];
