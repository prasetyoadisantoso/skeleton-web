<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\SEO;
use App\Services\Translations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class BlogController extends Controller
{
    protected $global_view, $global_variable, $translation, $post, $category, $tag, $seo;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        Translations $translation,
        Category $category,
        Post $post,
        Tag $tag,
        SEO $seo,
    ) {
        $this->middleware(['xss-sanitize', 'xss', 'honeypot'])->only(['search']);
        $this->global_view = $global_view;
        $this->global_variable = $global_variable;
        $this->translation = $translation;
        $this->post = $post;
        $this->category = $category;
        $this->tag = $tag;
        $this->seo = $seo;
    }

    protected function boot()
    {
        $this->global_view->RenderView([
            $this->global_variable->SiteLogo(),
            $this->global_variable->SiteFavicon(),
            $this->global_variable->GoogleTagId(),

            // Translations
            $this->translation->button,
            $this->translation->blog,

            // SEO
            $this->seo->MetaBlog(),
            $this->seo->OpengraphBlog(),

            [
                'method' => Route::current()->methods(),
            ],
        ]);
    }

    public function index()
    {
        $this->boot();
        $posts = $this->post->query()->latest()->paginate(5);
        $categories = $this->category->query()->get();
        $tags = $this->tag->query()->get();
        return view('template.default.frontend.page.blog', array_merge([
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags,
        ]));
    }

    public function search(Request $request)
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

        return view('template.default.frontend.page.blog', array_merge([
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags,
        ]));
    }

    public function category($category)
    {
        $this->boot();
        $posts = $this->post->query()->whereHas('categories', function ($query) use ($category) {
            $query->where('slug', $category);
        })->paginate(5);
        $categories = $this->category->query()->get();
        $tags = $this->tag->query()->get();

        return view('template.default.frontend.page.blog', array_merge([
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags,
        ]));
    }

    public function tag($tag)
    {
        $this->boot();
        $posts = $this->post->query()->whereHas('tags', function ($query) use ($tag) {
            $query->where('slug', $tag);
        })->paginate(5);
        $categories = $this->category->query()->get();
        $tags = $this->tag->query()->get();

        return view('template.default.frontend.page.blog', array_merge([
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags,
        ]));
    }

    public function post($post)
    {
        $this->boot();
        $posts = $this->post->query()->where('slug', $post)->first();
        $categories = $this->category->query()->get();
        $tags = $this->tag->query()->get();

        return view('template.default.frontend.page.post', array_merge([
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags,
        ]));
    }
}
