<?php

return [
    'title' => "Category",
    'breadcrumb' => [
        'title' => 'Category Setting',
        'home' => 'Home',
        'index' => 'Index Page',
        'create' => 'Create Page',
        'edit' => 'Edit Page',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Category Management',
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Name',
            'slug' => 'Slug',
            'parent' => 'Parent',
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
        'meta' => 'SEO Meta :',
        'select_meta' => '- Select Meta -',
        'opengraph' => 'SEO Open Graph :',
        'select_opengraph' => '- Select Open Graph -',
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
