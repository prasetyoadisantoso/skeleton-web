<?php

return [
    'title' => "Open Graph",
    'breadcrumb' => [
        'title' => 'Open Graph Settings',
        'home' => 'Home',
        'index' => 'Index Page',
        'create' => 'Create Page',
        'edit' => 'Edit Page',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Open Graph Management',
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Name',
            'title' => 'Title',
            'description' => 'Description',
            'url' => 'URL',
            'site_name' => 'Site Name',
            'action' => 'Action',
        ],
        'search' => 'Search: ',
        'previous' => 'Previous',
        'next' => 'Next',
        'info' => "Showing _START_ to _END_ of _TOTAL_ entries",
        'length_menu' => 'Show _MENU_ entries',
    ],

    'form' => [
        'create_title' => 'Create Open Graph',
        'edit_title' => 'Edit Open Graph',
        'name' => 'Name :',
        'name_placeholder' => 'Insert opengraph\'s name...',
        'title' => 'Title :',
        'title_placeholder' => 'Insert title...',
        'description' => 'Description :',
        'description_placeholder' => 'Insert description...',
        'url' => 'Url Address :',
        'url_placeholder' => 'Insert url address...',
        'site_name' => 'Site name :',
        'site_name_placeholder' => 'Insert site name...',
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
        'name_required' => 'Open Graph\'s name is required',
        'title_required' => 'Title is required',
        'description_required' => 'Description is required',
        'url_required' => 'URL is required',
        'site_name_required' => 'Site name is required',
    ],
];
