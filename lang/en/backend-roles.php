<?php

return [
    'title' => "Roles",
    'breadcrumb' => [
        'title' => 'Roles',
        'home' => 'Home',
        'index' => 'Index Page',
        'create' => 'Create Page',
        'edit' => 'Edit Page',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Roles Management',
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Role',
            'permission' => 'Permission',
            'action' => 'Action',
        ],
        'search' => 'Search: ',
        'previous' => 'Previous',
        'next' => 'Next',
        'info' => "Showing _START_ to _END_ of _TOTAL_ entries",
        'length_menu' => 'Show _MENU_ entries',
    ],

    'form' => [
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'name' => 'Role Name :',
        'name_placeholder' => 'Role name...',
        'permission_list' => 'Permission List :',
    ],

    'messages' => [
        'store_success' => 'Role stored successfully',
        'store_failed' => 'Role failed to store',
        'update_success' => 'Role updated successfully',
        'update_failed' => 'Role failed to update',
        'ask_delete' => 'Do you want to delete this role?',
        'delete_success' => 'Role deleted successfully',
        'delete_failed' => 'Role failed to delete',
    ],

    'validation' => [
        'name_required' => 'Role name is required',
    ],
];
