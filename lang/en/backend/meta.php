<?php

return [
    'title' => "Meta",
    'breadcrumb' => [
        'title' => 'Meta Setting',
        'home' => 'Home',
        'index' => 'Index Page',
        'create' => 'Create Page',
        'edit' => 'Edit Page',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Meta Management',
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Name',
            'robot' => 'Robots',
            'description' => 'Description',
            'keyword' => 'Keyword',
            'action' => 'Action',
        ],
        'search' => 'Search: ',
        'previous' => 'Previous',
        'next' => 'Next',
        'info' => "Showing _START_ to _END_ of _TOTAL_ entries",
        'length_menu' => 'Show _MENU_ entries',
    ],

    'form' => [
        'create_title' => 'Create Meta',
        'edit_title' => 'Edit Meta',
        'name' => 'Name :',
        'name_placeholder' => 'Insert meta name...',
        'robot' => 'Robots :',
        'robot_placeholder' => 'Insert robots text...',
        'description' => 'Description :',
        'description_placeholder' => 'Insert description text...',
        'keyword' => 'Keywords :',
        'keyword_placeholder' => 'Insert keyword text...',
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
        'name_required' => 'Meta name is required',
        'robot_required' => 'Meta robots is required',
        'description_required' => 'Meta description is required',
        'keyword_required' => 'Meta keyword is required',
    ],
];
