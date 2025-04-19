<?php

return [
    'title' => 'Pages',
    'breadcrumb' => [
        'title' => 'Page Management',
        'home' => 'Home',
        'index' => 'All Pages',
        'create' => 'Create Page',
        'edit' => 'Edit Page',
    ],
    'datatable' => [
        'header' => [
            'title' => 'List of Pages',
        ],
        'table' => [
            'number' => 'No',
            'title' => 'Title',
            'slug' => 'Slug',
            'layout' => 'Layout',
            'action' => 'Actions',
        ],
    ],
    'form' => [
        'create_title' => 'Create New Page',
        'edit_title' => 'Edit Page',
        'title' => 'Title:',
        'slug' => 'Slug:',
        'content' => 'Content:',
        'layout' => 'Layout:',
        'select_layout' => 'Select Layout',
        'meta' => 'Meta Data:',
        'select_meta' => 'Select Meta',
        'opengraph' => 'Open Graph:',
        'select_opengraph' => 'Select Open Graph',
        'canonical' => 'Canonical:',
        'select_canonical' => 'Select Canonical',
        'schema' => 'Schema Data:',
        'select_schema' => 'Select Schema Data',
    ],
    'messages' => [
        'store_success' => 'Page created successfully.', //Ditambahkan
        'update_success' => 'Page updated successfully.', //Ditambahkan
        'delete_success' => 'Page deleted successfully.', //Ditambahkan
        'ask_delete' => 'Are you sure you want to delete this page?',
        'delete_warning' => 'This action cannot be undone.',
        'delete_failed' => 'Page deletion failed.',
    ],
];
