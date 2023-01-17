<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use App\Services\GlobalView;
use Illuminate\Http\Request;
use App\Services\GlobalVariable;
use App\Services\Translations;
use App\Models\Post;

class BlogController extends Controller
{
    protected $global_view, $global_variable, $translation, $post;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        Translations $translation,
        Post $post,
    )
    {
        $this->global_view = $global_view;
        $this->global_variable = $global_variable;
        $this->translation = $translation;
        $this->post = $post;
    }

    protected function boot()
    {
        $this->global_view->RenderView([
            $this->global_variable->SiteLogo(),

            // Translations
            $this->translation->home,
        ]);
    }

    public function index()
    {
        $this->boot();
        $posts = $this->post->query()->latest()->paginate(1);
        return view('template.default.customer.blog', array_merge([
            'posts' => $posts
        ]));
    }
}
