<?php

return [

    'breadcrumb' => [
        'title' => 'Users',
        'home' => 'Home',
        'index' => 'Index Page',
        'create' => 'Create Page',
        'edit' => 'Edit Page',
    ],

    'datatable' => [
        'header' => [
            'title' => 'Users Management',
        ],
        'table' => [
            'number' => 'No',
            'name' => 'Name',
            'image' => 'Image',
            'email' => 'Email',
            'role' => 'Role',
            'action' => 'Action',
        ],
        'search' => 'Search: ',
        'previous' => 'Previous',
        'next' => 'Next',
        'info' => "Showing _START_ to _END_ of _TOTAL_ entries",
        'length_menu' => 'Show _MENU_ entries',
    ],

    'detail' => [
        'title' => 'Detail User',
        'name' => 'Name',
        'email' => 'Email',
        'phone' => 'Phone',
        'role' => 'Role',
        'is_verified' => 'Is Verified ?',
    ],

    'form' => [
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'image_note' => '*Click picture above to add a new image',
        'name' => 'Full Name :',
        'name_placeholder' => 'Full name...',
        'email' => 'Email :',
        'email_placeholder' => 'Email...',
        'phone' => 'Phone Number :',
        'phone_placeholder' => 'Phone number...',
        'role' => 'Role :',
        'role_placeholder' => 'Select role...',
        'password' => 'Password :',
        'password_placeholder' => 'Password...',
        'confirm_password' => 'Password Confirmation :',
        'confirm_password_placeholder' => 'Password confirmation...',
        'verification_status' => 'Verification Status :',
    ],

    'messages' => [
        'store_success' => 'User stored successfully',
        'store_failed' => 'User failed to store',
    ],

    'validation' => [
        'fullname_required' => 'full name is required',
        'email_required' => 'email is required',
        'email_contained' => 'must be contained email format',
        'phone_required' => 'phone is required',
        'role_required' => "role is required",
        'password_required' => 'password is required',
        'confirm_password_required' => 'confirm password is required',
        'confirm_password_same' => 'password confirmation must be same with password',
    ],

];
