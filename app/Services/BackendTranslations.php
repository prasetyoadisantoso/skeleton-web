<?php

namespace App\Services;

#[\AllowDynamicProperties]
class BackendTranslations
{
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
