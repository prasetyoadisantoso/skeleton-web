<?php

namespace App\Services;

use App\Models\Meta;
use App\Models\Opengraph;

class SEO
{

    protected $meta, $opengraph;

    public function __construct(
        Meta $meta,
        Opengraph $opengraph,
    ) {
        $this->meta = $meta;
        $this->opengraph = $opengraph;
    }


    // Home
    public function MetaHome()
    {
        return [
            'meta' => $this->meta->query()->where('name', 'Home')->get()
        ];
    }

    public function OpengraphHome() {;

        return [
            'opengraph' => $this->opengraph->query()->where('name', 'Home')->get()
        ];
    }

    // Blog
    public function MetaBlog()
    {
        return [
            'meta' => $this->meta->query()->where('name', 'Blog')->get()
        ];
    }

    public function OpengraphBlog() {;

        return [
            'opengraph' => $this->opengraph->query()->where('name', 'Blog')->get()
        ];
    }

    // Contact
    public function MetaContact()
    {
        return [
            'meta' => $this->meta->query()->where('name', 'Contact')->get()
        ];
    }

    public function OpengraphContact() {;

        return [
            'opengraph' => $this->opengraph->query()->where('name', 'Contact')->get()
        ];
    }



}
