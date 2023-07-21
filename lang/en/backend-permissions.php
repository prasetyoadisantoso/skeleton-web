<?php

return [
    'title' => "Permissions",
    'breadcrumb' => [
        'title' => 'Permissions',
        'home' => 'Home',
        'index' => 'Index Page',
        'create' => 'Create Page',
        'edit' => 'Edit Page',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Permissions Management',
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Name',
            'action' => 'Action',
        ],
        'search' => 'Search: ',
        'previous' => 'Previous',
        'next' => 'Next',
        'info' => "Showing _START_ to _END_ of _TOTAL_ entries",
        'length_menu' => 'Show _MENU_ entries',
    ],

    'form' => [
        'create_title' => 'Create Permissions',
        'edit_title' => 'Edit Permissions',
        'name' => 'Permission Name :',
        'name_placeholder' => 'Permission name...',
    ],

    'messages' => [
        'store_success' => 'Permission stored successfully',
        'store_failed' => 'Permission failed to store',
        'update_success' => 'Permission updated successfully',
        'update_failed' => 'Persmission failed to update',
        'ask_delete' => 'Do you want to delete this permission?',
        'delete_success' => 'Permission deleted successfully',
        'delete_failed' => 'Permission failed to delete',
    ],

    'validation' => [
        'name_required' => 'Permission name is required',
    ],
];
