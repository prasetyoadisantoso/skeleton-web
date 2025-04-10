<?php

namespace App\Services;

use \AllowDynamicProperties;
#[AllowDynamicProperties]

class FrontendTranslations {

    public function __construct()
    {

        // Header
        $this->header_translation = __('frontend/header');

        // Main
        $this->home_translation = __('frontend/home');
        $this->blog_translation = __('frontend/blog');
        $this->contact_translation = __('frontend/contact');
        $this->button_translation = __('frontend/button');

        // Footer
        $this->footer_translation = __('frontend/footer');

    }

}
