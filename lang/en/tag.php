<?php

return [
    'title' => "Tag",
    'breadcrumb' => [
        'title' => 'Tag Setting',
        'home' => 'Home',
        'index' => 'Index Page',
        'create' => 'Create Page',
        'edit' => 'Edit Page',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Tag Management',
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Name',
            'slug' => 'Slug',
            'action' => 'Action',
        ],
        'search' => 'Search: ',
        'previous' => 'Previous',
        'next' => 'Next',
        'info' => "Showing _START_ to _END_ of _TOTAL_ entries",
        'length_menu' => 'Show _MENU_ entries',
    ],

    'form' => [
        'create_title' => 'Create Tag',
        'edit_title' => 'Edit Tag',
        'name' => 'Name :',
        'name_placeholder' => 'Insert tag name...',
        'slug' => 'Slug :',
        'slug_placeholder' => 'Insert slug...',
    ],

    'messages' => [
        'store_success' => 'Data stored successfully',
        'store_failed' => 'Data failed to store',
        'update_success' => 'Data updated successfully',
        'update_failed' => 'Data failed to update',
        'ask_delete' => 'Do you want to delete this permission?',
        'delete_success' => 'Data deleted successfully',
        'delete_failed' => 'Data failed to delete',
    ],

    'validation' => [
        'name_required' => 'Tag name is required',
        'slug_required' => 'Tag slug is required',
    ],
];
