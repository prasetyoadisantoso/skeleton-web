<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageFormRequest;
use Illuminate\Http\Request;
use App\Models\SocialMedia;
use App\Services\GlobalView;
use App\Services\GlobalVariable;
use App\Services\Translations;
use App\Services\Email;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\SEO;

class ContactController extends Controller
{
    protected $global_view, $global_variable, $translation, $social_media, $email, $seo;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        SocialMedia $social_media,
        Translations $translation,
        Email $email,
        Message $message,
        SEO $seo,
    )
    {
        $this->middleware(['xss', 'xss-sanitize', 'honeypot'])->only(['message']);
        $this->global_view = $global_view;
        $this->global_variable = $global_variable;
        $this->social_media = $social_media;
        $this->translation = $translation;
        $this->email = $email;
        $this->message = $message;
        $this->seo = $seo;
    }

    protected function boot()
    {
        $this->global_view->RenderView([
            $this->global_variable->SiteLogo(),
            $this->global_variable->SiteFavicon(),
            $this->global_variable->GoogleTagId(),

            // Translations
            $this->translation->contact,
            $this->translation->button,

            // SEO
            $this->seo->MetaContact(),
            $this->seo->OpengraphContact(),
            $this->seo->CanonicalContact(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->boot();
        return view('template.default.frontend.page.contact', array_merge([
        ]));
    }

    public function message(MessageFormRequest $request)
    {
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->log($request->validator->messages());
        }
        DB::beginTransaction();
        try {
            $request->validated();
            $contact = $request->only(['name', 'email', 'phone', 'message']);
            $this->email->EmailContact($this->global_variable->SiteEmail()['site_email'], $contact);
            activity()->causedBy(Auth::user())->log($this->translation->contact['messages']['message_sent']);

            $this->message->StoreMessage($contact);
            activity()->causedBy(Auth::user())->performedOn(new Message)->log($this->translation->contact['messages']['store_success']);

            DB::commit();

            return redirect()->route('site.contact')->with([
                'success' => 'success',
                'message' => $this->translation->contact['messages']['message_sent'],
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            $message = $th->getMessage();
            activity()->causedBy(Auth::user())->performedOn(new Message)->log($message);
            report($th->getMessage());

            return redirect()->route('site.contact')->with([
                'error' => 'error',
                'message' => $this->translation->contact['messages']['message_not_sent']
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
