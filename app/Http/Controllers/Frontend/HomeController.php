<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use App\Services\GlobalView;
use Illuminate\Http\Request;
use App\Services\GlobalVariable;
use App\Services\Translations;

class HomeController extends Controller
{
    protected $global_view, $global_variable, $translation, $social_media;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        SocialMedia $social_media,
        Translations $translation,
    )
    {
        $this->global_view = $global_view;
        $this->global_variable = $global_variable;
        $this->social_media = $social_media;
        $this->translation = $translation;
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
        $social_media = $this->social_media->query()->where('name', 'Instagram')->orWhere('name', 'Github')->orWhere('name', 'Gitlab')->get();
        return view('template.default.frontend.home', array_merge([
            'social_media' => $social_media->toArray()
        ]));
    }
}
