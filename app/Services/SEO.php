<?php

namespace App\Services;

use App\Models\Meta;
use App\Models\Opengraph;
use App\Models\Post;

class SEO
{

    protected $meta, $opengraph;

    public function __construct(
        Meta $meta,
        Opengraph $opengraph,
        Post $posts,
    ) {
        $this->meta = $meta;
        $this->opengraph = $opengraph;
        $this->posts = $posts;
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

    // Frontend Blog
    public function MetaBlog()
    {
        return $this->meta->query()->where('name', 'Blog')->get();
    }

    public function OpengraphBlog() {;

        return $this->opengraph->query()->where('name', 'Blog')->get();
    }

    // Frontend Posts
    public function MetaPost($slug) {
        $post = $this->posts->where('slug', $slug)->first();
        return $post->metas()->get();
    }

    public function OpengraphPost($slug) {
        $post = $this->posts->where('slug', $slug)->first();
        return $post->opengraphs()->get();
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
