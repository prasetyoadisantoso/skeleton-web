<?php

return [
    'title' => "Media Library",
    'breadcrumb' => [
        'title' => 'Media Library',
        'home' => 'Home',
        'index' => 'Index Page',
        'create' => 'Create Page',
        'edit' => 'Edit Page',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Media Library Management',
        ],
        'table' => [
            'number' => 'No',
            'title' => 'Title',
            'media_files' => 'Media Files',
            'action' => 'Action',
        ],
        'search' => 'Search: ',
        'previous' => 'Previous',
        'next' => 'Next',
        'info' => "Showing _START_ to _END_ of _TOTAL_ entries",
        'length_menu' => 'Show _MENU_ entries',
    ],

    'form' => [
        'create_title' => 'Create File',
        'edit_title' => 'Edit File',
        'title' => 'Title :',
        'title_placeholder' => 'Insert title...',
        'information' => 'Information :',
        'information_placeholder' => 'Insert information...',
        'description' => 'Description :',
        'description_placeholder' => 'Insert your description here...',
        'mediafile' => 'Media File :',
    ],

    'messages' => [
        'store_success' => 'Media File stored successfully',
        'store_failed' => 'Media File failed to store',
        'update_success' => 'Media File updated successfully',
        'update_failed' => 'Media File failed to update',
        'ask_delete' => 'Do you want to delete this File?',
        'delete_success' => 'Media File deleted successfully',
        'delete_failed' => 'Media File failed to delete',
        'mediafile_not_available' => 'Media File not available',
    ],

    'validation' => [
        'title_required' => 'Title is required',
        'content_required' => 'Content is required',
        'feature_image_required' => 'Feature image is required',
    ],
];
