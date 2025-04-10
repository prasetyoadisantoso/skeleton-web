<?php

return [
    'title' => 'Schema',
    'breadcrumb' => [
        'title' => 'Schema Management',
        'home' => 'Home',
        'index' => 'Index Page',
        'create' => 'Create Page',
        'edit' => 'Edit Page',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Schema List',
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Name',
            'type' => 'Type',
            'content' => 'Content',
            'action' => 'Action',
        ],
        'search' => 'Search: ',
        'previous' => 'Previous',
        'next' => 'Next',
        'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
        'length_menu' => 'Show _MENU_ entries',
    ],

    'form' => [
        'create_title' => 'Create Schema',
        'edit_title' => 'Edit Schema',
        'type' => 'Type :',
        'type_placeholder' => 'Insert schema type...',
        'content' => 'Konten :',
        'content_placeholder' => 'Insert schema content...',
    ],

    'messages' => [
        'store_success' => 'Data stored successfully',
        'store_failed' => 'Data failed to store',
        'update_success' => 'Data updated successfully',
        'update_failed' => 'Data failed to update',
        'ask_delete' => 'Do you want to delete this?',
        'delete_success' => 'Data deleted successfully',
        'delete_failed' => 'Data failed to delete',
    ],

    'validation' => [
        'type_required' => 'Schema type is required',
        'content_required' => 'Schema content is required',
    ],
];
