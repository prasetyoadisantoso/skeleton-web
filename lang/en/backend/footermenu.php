<?php

return [
    'title' => 'Footer Menu',
    'breadcrumb' => [
        'title' => 'Footer Menu Settings',
        'home' => 'Home',
        'index' => 'Index Page',
        'create' => 'Create Page',
        'edit' => 'Edit Page',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Footer Menu Management',
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Name',
            'label' => 'Label',
            'url' => 'URL',
            'order' => 'Order',
            'target' => 'Target',
            'status' => 'Status',
            'action' => 'Action',
        ],
        'search' => 'Search: ',
        'previous' => 'Previous',
        'next' => 'Next',
        'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
        'length_menu' => 'Show _MENU_ entries',
    ],

    'form' => [
        'create_title' => 'Create Footer Menu',
        'edit_title' => 'Edit Footer Menu',
        'name' => 'Name :',
        'name_placeholder' => 'Insert menu name...',
        'name_help' => 'Unique name for internal identification.', // New
        'label' => 'Label :',
        'label_placeholder' => 'Insert label...',
        'label_help' => 'Text displayed in the menu.', // New
        'url' => 'URL :',
        'url_placeholder' => 'Insert URL...',
        'url_help' => 'Target URL (can be external or internal).', // New
        'icon' => 'Icon :',
        'icon_placeholder' => 'Insert icon class...',
        'icon_help' => 'CSS class for the icon (e.g., FontAwesome).', // New
        'order' => 'Order :',
        'order_placeholder' => 'Insert order number...',
        'order_help' => 'Order in which the menu is displayed.', // New
        'target' => 'Target :',
        'target_placeholder' => 'Insert target...',
        'target_self' => '_self (Same Tab)', // New
        'target_blank' => '_blank (New Tab)', // New
        'target_help' => 'Target for the menu link.', // New
        'status' => 'Status :', // Keep this if used elsewhere, or remove if only 'active_label' is needed
        'status_placeholder' => 'Set status...', // Keep or remove
        'active_label' => 'Active', // New for checkbox label
    ],

    'messages' => [
        'store_success' => 'Footer Menu stored successfully',
        'store_failed' => 'Footer Menu failed to store',
        'update_success' => 'Footer Menu updated successfully',
        'update_failed' => 'Footer Menu failed to update',
        'ask_delete' => 'Do you want to delete this Header Menu?',
        'delete_success' => 'Footer Menu deleted successfully',
        'delete_failed' => 'Footer Menu failed to delete',
    ],

    'validation' => [
        'name_required' => 'Menu name is required',
        'label_required' => 'Label is required',
        'order_required' => 'Order is required',
    ],
];
