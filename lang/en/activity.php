<?php

return [
    'title' => "Activity",
    'breadcrumb' => [
        'title' => 'Activity List',
        'home' => 'Home',
        'index' => 'Index Page',
        'create' => 'Create Page',
        'edit' => 'Edit Page',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Activity Management',
        ],
        'table' => [
            'number' => 'No',
            'ip_address' => 'IP Address',
            'user' => 'User',
            'activity' => 'Activity',
            'date' => 'Date',
            'time' => 'Time',
            'model' => 'Model',
            'action' => 'Action',
        ],
        'search' => 'Search: ',
        'previous' => 'Previous',
        'next' => 'Next',
        'info' => "Showing _START_ to _END_ of _TOTAL_ entries",
        'length_menu' => 'Show _MENU_ entries',
    ],

    'messages' => [
        'ask_empty' => 'Do you want to empty all activities?',
        'ask_delete' => 'Do you want to delete this activities?',
        'delete_success' => 'Data deleted successfully',
        'delete_failed' => 'Data failed to delete',
    ],

];
