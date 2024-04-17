<?php

namespace App\Services;

use App\Models\Canonical;
use App\Models\Category;
use App\Models\Meta;
use App\Models\Opengraph;
use App\Models\Post;
use App\Models\Tag;

class SEO
{

    protected $meta, $opengraph, $canonical;

    public function __construct(
        Meta $meta,
        Opengraph $opengraph,
        Post $posts,
        Category $category,
        Tag $tag,
        Canonical $canonical,
    ) {
        $this->meta = $meta;
        $this->opengraph = $opengraph;
        $this->posts = $posts;
        $this->category = $category;
        $this->tag = $tag;
        $this->canonical = $canonical;
    }

    /* -------------------------------------------------------------------------- */
    /*                                  Home SEO                                  */
    /* -------------------------------------------------------------------------- */
    public function MetaHome()
    {
        return [
            'meta' => $this->meta->query()->where('name', 'Home')->get(),
        ];
    }

    public function OpengraphHome()
    {;

        return [
            'opengraph' => $this->opengraph->query()->where('name', 'Home')->get(),
        ];
    }

    public function CanonicalHome()
    {
        return [
            'canonical' => $this->canonical->query()->where('name', 'Home')->get(),
        ];
    }

    /* -------------------------------------------------------------------------- */
    /*                                  Blog SEO                                  */
    /* -------------------------------------------------------------------------- */
    public function MetaBlog()
    {
        return $this->meta->query()->where('name', 'Blog')->get();
    }

    public function OpengraphBlog()
    {;

        return $this->opengraph->query()->where('name', 'Blog')->get();
    }

    public function CanonicalBlog()
    {
        return $this->canonical->query()->where('name', 'Blog')->get();
    }

    /* -------------------------------------------------------------------------- */
    /*                                  Posts SEO                                 */
    /* -------------------------------------------------------------------------- */
    public function MetaPost($slug)
    {
        $post = $this->posts->where('slug', $slug)->first();
        return $post->metas()->get();
    }

    public function OpengraphPost($slug)
    {
        $post = $this->posts->where('slug', $slug)->first();
        return $post->opengraphs()->get();
    }

    public function CanonicalPost($slug)
    {
        $post = $this->posts->query()->where('slug', $slug)->first();
        return $post->canonicals()->get();
    }

    /* -------------------------------------------------------------------------- */
    /*                                 Search SEO                                 */
    /* -------------------------------------------------------------------------- */
    public function MetaSearchPost()
    {
        return $this->meta->query()->where('name', 'Blog - Search')->get();
    }

    public function OpengraphSearchPost()
    {
        return $this->opengraph->query()->where('name', 'Blog - Search')->get();
    }

    /* -------------------------------------------------------------------------- */
    /*                                Category SEO                                */
    /* -------------------------------------------------------------------------- */
    public function MetaCategoryPost($slug)
    {
        $meta = $this->category->where('slug', $slug)->first();
        return $meta->metas()->get();
    }

    public function OpengraphCategoryPost($slug)
    {
        $opengraph = $this->category->where('slug', $slug)->first();
        return $opengraph->opengraphs()->get();
    }

    /* -------------------------------------------------------------------------- */
    /*                                   Tag SEO                                  */
    /* -------------------------------------------------------------------------- */
    public function MetaTagPost($slug)
    {
        $meta = $this->tag->where('slug', $slug)->first();
        return $meta->metas()->get();
    }

    public function OpengraphTagPost($slug)
    {
        $opengraph = $this->tag->where('slug', $slug)->first();
        return $opengraph->opengraphs()->get();
    }

    /* -------------------------------------------------------------------------- */
    /*                                 Contact SEO                                */
    /* -------------------------------------------------------------------------- */
    public function MetaContact()
    {
        return [
            'meta' => $this->meta->query()->where('name', 'Contact')->get(),
        ];
    }

    public function OpengraphContact()
    {;

        return [
            'opengraph' => $this->opengraph->query()->where('name', 'Contact')->get(),
        ];
    }

    public function CanonicalContact()
    {;

        return [
            'canonical' => $this->canonical->query()->where('name', 'Contact')->get(),
        ];
    }

}
