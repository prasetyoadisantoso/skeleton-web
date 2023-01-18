<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SocialMedia;
use App\Services\GlobalView;
use Illuminate\Http\Request;
use App\Services\GlobalVariable;
use App\Services\Translations;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Route;

class BlogController extends Controller
{
    protected $global_view, $global_variable, $translation, $post, $category, $tag;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        Translations $translation,
        Category $category,
        Post $post,
        Tag $tag,
    )
    {
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

            // Translations
            $this->translation->button,
            $this->translation->blog,

            [
                'method' => Route::current()->methods()
            ]
        ]);
    }

    public function index()
    {
        $this->boot();
        $posts = $this->post->query()->latest()->paginate(2);
        $categories = $this->category->query()->get();
        $tags = $this->tag->query()->get();
        return view('template.default.customer.blog', array_merge([
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags,
        ]));
    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required|string|max:15'
        ]);

        $input = $request->only(['search']);

        $this->boot();
        $posts = $this->post->query()->where('content','like',"%".$input['search']."%")->orWhere('title','like',"%".$input['search']."%")->paginate(1);
        $categories = $this->category->query()->get();
        $tags = $this->tag->query()->get();

        return view('template.default.customer.blog', array_merge([
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags,
        ]));
    }

    public function category($category)
    {
        $this->boot();
        $posts = $this->post->query()->whereHas('categories', function($query) use ($category){
            $query->where('slug', $category);
        })->paginate(1);
        $categories = $this->category->query()->get();
        $tags = $this->tag->query()->get();

        return view('template.default.customer.blog', array_merge([
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags,
        ]));
    }

    public function tag($tag)
    {
        $this->boot();
        $posts = $this->post->query()->whereHas('tags', function($query) use ($tag){
            $query->where('slug', $tag);
        })->paginate(1);
        $categories = $this->category->query()->get();
        $tags = $this->tag->query()->get();

        return view('template.default.customer.blog', array_merge([
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags,
        ]));
    }
}
