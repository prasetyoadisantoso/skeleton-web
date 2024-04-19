<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\SEO;
use App\Services\FrontendTranslations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class BlogController extends Controller
{
    protected $global_view, $global_variable, $translation, $post, $category, $tag, $seo;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        FrontendTranslations $translation,
        Category $category,
        Post $post,
        Tag $tag,
    ) {
        $this->middleware(['xss-sanitize', 'xss', 'honeypot'])->only(['search']);
        $this->global_view = $global_view;
        $this->global_variable = $global_variable;
        $this->translation = $translation;
        $this->post = $post;
        $this->category = $category;
        $this->tag = $tag;
    }

    protected function boot()
    {
        $this->global_view->RenderView([
            $this->global_variable->SiteLogo(),
            $this->global_variable->SiteFavicon(),
            $this->global_variable->GoogleTagId(),

            // Translations
            $this->translation->header_translation,
            $this->translation->blog_translation,
            $this->translation->button_translation,
            $this->translation->footer_translation,

            [
                'method' => Route::current()->methods(),
            ],
        ]);
    }

    public function index(SEO $seo)
    {
        $this->boot();
        $meta = $seo->MetaBlog();
        $opengraph = $seo->OpengraphBlog();
        $canonical = $seo->CanonicalBlog();

        $posts = $this->post->query()->latest()->paginate(5);
        $categories = $this->category->query()->get();
        $tags = $this->tag->query()->get();
        return view('template.default.frontend.page.blog', array_merge([
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags,
            'meta' => $meta,
            'opengraph' => $opengraph,
            'canonical' => $canonical,
        ]));
    }

    public function search(Request $request, SEO $seo)
    {
        $this->boot();
        try {
            $request->validate([
                'search' => 'required|string|max:50',
            ]);

            $input = $request->only(['search']);

            $posts = $this->post->query()->where('content', 'like', "%" . $input['search'] . "%")->orWhere('title', 'like', "%" . $input['search'] . "%")->paginate(5);
            $categories = $this->category->query()->get();
            $tags = $this->tag->query()->get();
        } catch (\Throwable $th) {
            report($th->getMessage());
            return redirect()->back();
        }

        $meta = $seo->MetaSearchPost();
        $opengraph = $seo->OpengraphSearchPost();

        return view('template.default.frontend.page.blog', array_merge([
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags,
            'meta' => $meta,
            'opengraph' => $opengraph,
        ]));
    }

    public function category($category,  SEO $seo)
    {
        $this->boot();
        $posts = $this->post->query()->whereHas('categories', function ($query) use ($category) {
            $query->where('slug', $category);
        })->paginate(5);
        $categories = $this->category->query()->get();
        $tags = $this->tag->query()->get();
        $meta = $seo->MetaCategoryPost($category);
        $opengraph = $seo->OpengraphCategoryPost($category);

        return view('template.default.frontend.page.blog', array_merge([
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags,
            'meta' => $meta,
            'opengraph' => $opengraph,
        ]));
    }

    public function tag($tag, SEO $seo)
    {
        $this->boot();
        $posts = $this->post->query()->whereHas('tags', function ($query) use ($tag) {
            $query->where('slug', $tag);
        })->paginate(5);
        $categories = $this->category->query()->get();
        $tags = $this->tag->query()->get();
        $meta = $seo->MetaTagPost($tag);
        $opengraph = $seo->OpengraphTagPost($tag);

        return view('template.default.frontend.page.blog', array_merge([
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags,
            'meta' => $meta,
            'opengraph' => $opengraph,
        ]));
    }

    public function post($post, SEO $seo)
    {
        $this->boot();
        $posts = $this->post->where('slug', $post)->first();
        $categories = $this->category->query()->get();
        $tags = $this->tag->query()->get();
        $meta = $seo->MetaPost($post);
        $opengraph = $seo->OpengraphPost($post);
        $canonical = $seo->CanonicalPost($post);

        return view('template.default.frontend.page.post', array_merge([
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags,
            'meta' => $meta,
            'opengraph' => $opengraph,
            'canonical' => $canonical,
        ]));
    }
}
