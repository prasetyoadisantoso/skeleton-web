<?php

return [
    'title' => "Social Media",
    'breadcrumb' => [
        'title' => 'Social Media',
        'home' => 'Home',
        'index' => 'Index Page',
        'create' => 'Create Page',
        'edit' => 'Edit Page',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Social Media Management',
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Name',
            'url' => 'url',
            'action' => 'Action',
        ],
        'search' => 'Search: ',
        'previous' => 'Previous',
        'next' => 'Next',
        'info' => "Showing _START_ to _END_ of _TOTAL_ entries",
        'length_menu' => 'Show _MENU_ entries',
    ],

    'form' => [
        'create_title' => 'Create Social Media',
        'edit_title' => 'Edit Social Media',
        'name' => 'Name :',
        'name_placeholder' => 'Insert social media name...',
        'url' => 'Url Address :',
        'url_placeholder' => 'Insert url address...',
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
        'name_required' => 'Social media name is required',
        'url_required' => 'Social media url is required',
    ],
];
