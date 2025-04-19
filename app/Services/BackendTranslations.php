<?php

namespace App\Services;

#[\AllowDynamicProperties]
class BackendTranslations
{
    public $header;
    public $sidebar;
    public $button;
    public $notification;
    public $select;
    public $main;
    public $header_menu;
    public $footer_menu;
    public $component;
    public $section;
    public $layout;
    public $page;
    public $contentimage;
    public $contenttext;
    public $post;
    public $medialibrary;
    public $category;
    public $tag;
    public $users;
    public $permissions;
    public $roles;
    public $general;
    public $social_media;
    public $message;
    public $meta;
    public $canonical;
    public $opengraph;
    public $schema;
    public $activity;
    public $maintenance;

    public function __construct()
    {
        /* -------------------------------------------------------------------------- */
        /*                                   Backend */
        /* -------------------------------------------------------------------------- */
        // Header
        $this->header = __('backend/header');

        // Sidebar
        $this->sidebar = __('backend/sidebar');

        // Button
        $this->button = __('backend/button');

        // Notification
        $this->notification = __('backend/notification');

        // Select
        $this->select = __('backend/select');

        // Main Dashboard
        $this->main = __('backend/main');

        // Navigation
        $this->header_menu = __('backend/headermenu');
        $this->footer_menu = __('backend/footermenu');

        // Template
        $this->component = __('backend/component');
        $this->section = __('backend/section');
        $this->layout = __('backend/layout');
        $this->page = __('backend/page');

        // Content
        $this->contentimage = __('backend/contentimage');
        $this->contenttext = __('backend/contenttext');

        // Post Dashboard
        $this->post = __('backend/post');

        // Media Library Dashboard
        $this->medialibrary = __('backend/medialibrary');

        // Category Dashboard
        $this->category = __('backend/category');

        // Tag Dashboard
        $this->tag = __('backend/tag');

        // User Dashboard
        $this->users = __('backend/users');

        // Permission Dashboard
        $this->permissions = __('backend/permissions');

        // Role Dashboard
        $this->roles = __('backend/roles');

        // General Dashboard
        $this->general = __('backend/general');
        $this->social_media = __('backend/social-media');

        // Email Dashboard
        $this->message = __('backend/message');

        // SEO Dashboard
        $this->meta = __('backend/meta');
        $this->canonical = __('backend/canonical');
        $this->opengraph = __('backend/opengraph');
        $this->schema = __('backend/schema');

        // System Dashboard
        $this->activity = __('backend/activity');
        $this->maintenance = __('backend/maintenance');
    }
}
