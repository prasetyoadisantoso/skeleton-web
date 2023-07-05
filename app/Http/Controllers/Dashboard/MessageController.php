<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\ResponseFormatter;
use App\Services\Translations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MessageController extends Controller
{

    protected $global_view, $global_variable, $translation, $dataTables, $message, $responseFormatter;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        Translations $translation,
        DataTables $dataTables,
        Message $message,
        ResponseFormatter $responseFormatter,
    ) {
        $this->middleware(['auth', 'verified', 'xss']);
        $this->middleware(['permission:setting-sidebar']);
        $this->middleware(['permission:message-index'])->only(['index', 'index_dt']);
        $this->middleware(['permission:message-create'])->only('create');
        $this->middleware(['permission:message-edit'])->only('edit');
        $this->middleware(['permission:message-store'])->only('store');
        $this->middleware(['permission:message-update'])->only('update');
        $this->middleware(['permission:message-destroy'])->only('destroy');
        $this->global_view = $global_view;
        $this->global_variable = $global_variable;
        $this->translation = $translation;
        $this->dataTables = $dataTables;
        $this->message = $message;
        $this->responseFormatter = $responseFormatter;
    }

    protected function boot()
    {
        return $this->global_view->RenderView([
            $this->global_variable->TitlePage($this->translation->message['title']),
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),
            $this->global_variable->SiteLogo(),
            $this->global_variable->MessageNotification(),

            // Translations
            $this->translation->header,
            $this->translation->sidebar,
            $this->translation->button,
            $this->translation->message,
            $this->translation->notification,

            // Module
            $this->global_variable->ModuleType([
                'message-home',
                'message-form',
            ]),

            // Script
            $this->global_variable->ScriptType([
                'message-home-js',
                'message-form-js',
            ]),

            // Route Type
            $this->global_variable->RouteType('message.index'),
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
        return view('template.default.dashboard.email.message.home', array_merge(
            $this->global_variable->PageType('index'),
        ));
    }

    public function index_dt()
    {
        $query = $this->message->query();
        $query->orderByRaw('-read_at ASC');
        return $this->dataTables->of($query)
            ->addColumn('name', function ($message) {
                return $message->name;
            })
            ->addColumn('email', function ($message) {
                return $message->email;
            })
            ->addColumn('read_at', function ($message) {
                return $message->read_at;
            })
            ->addColumn('action', function ($message) {
                return $message->id;
            })
            ->removeColumn('id')->addIndexColumn()->make('true');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
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
        $message = $this->message->GetMessageById($id);
        return $this->responseFormatter->successResponse([
            "message" => $message,
        ]);
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
        DB::beginTransaction();
        try {
            $delete = $this->message->DeleteMessage($id);
            DB::commit();

            // check data deleted or not
            if ($delete == true) {
                $status = 'success';
            } else {
                $status = 'error';
            }

            activity()->causedBy(Auth::user())->performedOn(new Message())->log($this->translation->message['messages']['delete_success']);

            ///  Return response
            return response()->json(['status' => $status]);
        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            activity()->causedBy(Auth::user())->performedOn(new Message)->log($message);
            return redirect()->back()->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message,
            ]);

        }
    }

    public function getRead($id)
    {
        $get_read = $this->message->GetMessageById($id);
        return $this->responseFormatter->successResponse([
            'read_at' => $get_read->only(['read_at']),
        ]);
    }

    public function ReadOn(Request $request)
    {
        $get_read = $this->message->GetMessageById($request->id);
        $get_read->read_at = date('Y-m-d H:i:s');
        $get_read->save();
        activity()->causedBy(Auth::user())->performedOn(new Message())->log($this->translation->message['messages']['update_success']);
        return $this->responseFormatter->successResponse([
            'read_at' => $get_read->only(['read_at']),
        ]);
    }

    public function ReadOff(Request $request)
    {
        $get_read = $this->message->GetMessageById($request->id);
        $get_read->read_at = null;
        $get_read->save();
        activity()->causedBy(Auth::user())->performedOn(new Message())->log($this->translation->message['messages']['update_success']);
        return $this->responseFormatter->successResponse([
            'read_at' => $get_read->only(['read_at']),
        ]);
    }

    public function MessageNotificationCount() {
        return $this->global_variable->MessageNotification();
    }
}
