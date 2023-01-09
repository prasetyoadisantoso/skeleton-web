<?php

return [
    'title' => "Post",
    'breadcrumb' => [
        'title' => 'Posts',
        'home' => 'Home',
        'index' => 'Index Page',
        'create' => 'Create Page',
        'edit' => 'Edit Page',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Posts Management',
        ],
        'table' => [
            'number' => 'No',
            'title' => 'Title',
            'image' => 'Image',
            'published' => 'published',
            'action' => 'Action',
        ],
        'search' => 'Search: ',
        'previous' => 'Previous',
        'next' => 'Next',
        'info' => "Showing _START_ to _END_ of _TOTAL_ entries",
        'length_menu' => 'Show _MENU_ entries',
    ],

    'form' => [
        'create_title' => 'Create Category',
        'edit_title' => 'Edit Category',
        'name' => 'Name :',
        'name_placeholder' => 'Insert category name...',
        'slug' => 'Slug :',
        'slug_placeholder' => 'Insert slug...',
        'parent' => 'Select Parent :',
        'parent_placeholder' => '- Select Category Parent -',
    ],

    'messages' => [
        'store_success' => 'Category stored successfully',
        'store_failed' => 'Category failed to store',
        'update_success' => 'Category updated successfully',
        'update_failed' => 'Category failed to update',
        'ask_delete' => 'Do you want to delete this category?',
        'delete_success' => 'Category deleted successfully',
        'delete_failed' => 'Category failed to delete',
    ],

    'validation' => [
        'name_required' => 'Category name is required',
        'slug_required' => 'Category slug is required',
        'parent_required' => 'Category parent is required'
    ],
];
