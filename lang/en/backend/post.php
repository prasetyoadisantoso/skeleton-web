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
            'publish' => 'Publish',
            'action' => 'Action',
        ],
        'search' => 'Search: ',
        'previous' => 'Previous',
        'next' => 'Next',
        'info' => "Showing _START_ to _END_ of _TOTAL_ entries",
        'length_menu' => 'Show _MENU_ entries',
    ],

    'form' => [
        'create_title' => 'Create Post',
        'edit_title' => 'Edit Post',
        'title' => 'Title :',
        'title_placeholder' => 'Insert title...',
        'slug' => 'Slug :',
        'slug_placeholder' => 'Insert slug...',
        'content' => 'Content :',
        'content_placeholder' => 'Insert your content here...',
        'category' => 'Category :',
        'select_category' => '- Select Category -',
        'tag' => 'Tag :',
        'select_tag' => 'Select multiple tags',
        'meta' => 'SEO Meta :',
        'select_meta' => '- Select Meta -',
        'opengraph' => 'SEO Open Graph :',
        'select_opengraph' => '- Select Open Graph -',
        'canonical' => 'Canonical',
        'select_canonical' => '- Select Canonical -',
        'feature_image' => 'Feature Image :',
        'is_publish' => 'Is Publish ?'
    ],

    'detail' => [
        'title' => 'Title :',
        'feature_image' => 'Feature Image : ',
        'slug' => 'Slug :',
        'content' => 'Content :',
        'category' => 'Category :',
        'tags' => 'Tags :',
        'meta' => 'SEO Meta :',
        'opengraph' => 'SEO Open Graph :',
        'canonical' => 'SEO Canonical :',
        'author' => 'Author :',
        'is_published' => 'Is Published?',
        'yes' => 'Yes',
        'no' => 'No',
    ],

    'messages' => [
        'store_success' => 'Post stored successfully',
        'store_failed' => 'Post failed to store',
        'update_success' => 'Post updated successfully',
        'update_failed' => 'Post failed to update',
        'ask_delete' => 'Do you want to delete this Post?',
        'delete_success' => 'Post deleted successfully',
        'delete_failed' => 'Post failed to delete',
        'image_not_available' => 'Image not available',
    ],

    'validation' => [
        'title_required' => 'Title is required',
        'content_required' => 'Content is required',
        'feature_image_required' => 'Feature image is required',
    ],
];
