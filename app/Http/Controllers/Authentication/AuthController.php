<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthFormRequest;
use App\Models\Token;
use App\Models\User;
use App\Services\Email;
use App\Services\Encryption;
use App\Services\FileManagement;
use App\Services\Generator;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\ResponseFormatter;
use App\Services\Translations;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $generator, $global_view, $global_variable, $encryption, $user, $token, $email, $translation, $fileManagement, $responseFormatter;

    public function __construct(
        Generator $generator,
        Encryption $encryption,
        User $user,
        Token $token,
        Email $email,
        Translations $translation,
        FileManagement $fileManagement,
        ResponseFormatter $responseFormatter,
        GlobalView $global_view,
        GlobalVariable $global_variable,
    ) {
        $this->generator = $generator;
        $this->encryption = $encryption;
        $this->user = $user;
        $this->token = $token;
        $this->email = $email;
        $this->translation = $translation;
        $this->fileManagement = $fileManagement;
        $this->responseFormatter = $responseFormatter;
        $this->global_view = $global_view;
        $this->global_variable = $global_variable;
    }

    protected function boot()
    {
        $this->global_view->RenderView([
            $this->global_variable->SiteLogo(),
        ]);
    }

    public function login_page()
    {
        $this->boot();

        if (Auth::user() == null) {
            $translation_login = $this->translation->authLogin;
            $translation_messages = $this->translation->authMessages;
            $translation_validation = $this->translation->authValidation;
            return view('template.default.authentication.page.login', array_merge($translation_login, $translation_messages, $translation_validation));
        } else {
            return redirect()->route('dashboard.main');
        }
    }

    public function register_page()
    {
        $this->boot();

        if (Auth::user() == null) {
            $translation_registration = $this->translation->authRegistration;
            $translation_messages = $this->translation->authMessages;
            $translation_validation = $this->translation->authValidation;
            return view('template.default.authentication.page.registration', array_merge($translation_registration, $translation_messages, $translation_validation));
        } else {
            return redirect()->route('dashboard.main');
        }
    }

    public function resend_verification_page()
    {
        $this->boot();

        if (Auth::user() == null) {
            $translation_verification = $this->translation->authVerification;
            $translation_messages = $this->translation->authMessages;
            $translation_validation = $this->translation->authValidation;
            return view('template.default.authentication.page.resend-verification', array_merge($translation_verification, $translation_messages, $translation_validation));
        } else {
            return redirect()->route('dashboard.main');
        }
    }

    public function forgot_password_page()
    {
        $this->boot();

        if (Auth::user() == null) {
            $translation_forgot_password = $this->translation->authForgotPassword;
            $translation_messages = $this->translation->authMessages;
            $translation_validation = $this->translation->authValidation;
            return view('template.default.authentication.page.forgot-password', array_merge($translation_forgot_password, $translation_messages, $translation_validation));
        } else {
            return redirect()->route('dashboard.main');
        }
    }

    public function reset_password_page($token)
    {
        $this->boot();

        if (Auth::user() == null) {
            $data_token = $this->token->GetUUIDByToken($this->encryption->DecryptToken($token));
            $dataUser = $this->user->GetUserByID($data_token->user_id);

            $translation_resetpassword = $this->translation->authResetPassword;
            $translation_messages = $this->translation->authMessages;
            $translation_validation = $this->translation->authValidation;

            try {
                if (is_null($dataUser)) {
                    throw new Exception($this->translation->authMessages['token_invalid']);
                } else {
                    activity()->causedBy($dataUser->id)->performedOn(new User)->log($translation_messages['process']);
                    return view('template.default.authentication.page.reset-password', array_merge([
                        'token' => $token,
                    ], $translation_resetpassword, $translation_messages, $translation_validation));
                }
            } catch (\Throwable$th) {
                $message = $th->getMessage();
                report($message);
                activity()->causedBy(Auth::user())->performedOn(new User)->log($th->getMessage());
                return redirect()->route('forgot.password.page')->with([
                    'error' => $th->getMessage(),
                ]);
            }
        } else {
            return redirect()->route('dashboard.main');
        }
    }

    public function login(AuthFormRequest $request)
    {
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new User)->log($request->validator->messages());
        }
        $request->validated();
        $user = $request->only(['email', 'password']);
        $remember_me = $request->only(['remember_me']);
        Auth::attempt($user, $remember_me != null ? true : false);
        $auth = Auth::user();
        try {
            if ($auth != null) {
                switch ($auth->roles->pluck('name')->first()) {

                    // SuperAdmin
                    case 'superadmin':
                        if ($auth->email_verified_at != null) {
                            activity()->causedBy(Auth::user())->performedOn(new User)->log($this->translation->authMessages['login_success']);
                            return redirect()->route('dashboard.main')->with([
                                'success' => $this->translation->authMessages['login_success'],
                                'title' => $this->translation->notification['success'],
                                'content' => $this->translation->authMessages['login_success'],
                            ]);
                        } else {
                            Auth::logout();
                            activity()->causedBy(Auth::user())->performedOn(new User)->log($this->translation->authMessages['email_not_verified']);
                            return redirect()->route('login.page')->with([
                                'error' => $this->translation->authMessages['email_not_verified'],
                                'title' => $this->translation->notification['failed'],
                                'content' => $this->translation->authMessages['email_not_verified'],
                            ]);
                        }
                        break;

                    // Administrator
                    case 'administrator':
                        if ($auth->email_verified_at != null) {
                            activity()->causedBy(Auth::user())->performedOn(new User)->log($this->translation->authMessages['login_success']);
                            return redirect()->route('dashboard.main')->with([
                                'success' => $this->translation->authMessages['login_success'],
                                'title' => $this->translation->notification['success'],
                                'content' => $this->translation->authMessages['login_success'],
                            ]);
                        } else {
                            Auth::logout();
                            activity()->causedBy(Auth::user())->performedOn(new User)->log($this->translation->authMessages['email_not_verified']);
                            return redirect()->route('login.page')->with([
                                'error' => $this->translation->authMessages['email_not_verified'],
                                'title' => $this->translation->notification['failed'],
                                'content' => $this->translation->authMessages['email_not_verified'],
                            ]);
                        }
                        break;

                    // Customer
                    case 'customer':
                        if ($auth->email_verified_at != null) {
                            activity()->causedBy(Auth::user())->performedOn(new User)->log($this->translation->authMessages['login_success']);
                            return redirect()->route('site.index')->with([
                                'success' => $this->translation->authMessages['login_success'],
                                'title' => $this->translation->notification['success'],
                                'content' => $this->translation->authMessages['login_success'],
                            ]);
                        } else {
                            Auth::logout();
                            activity()->causedBy(Auth::user())->performedOn(new User)->log($this->translation->authMessages['email_not_verified']);
                            return redirect()->route('resend.verification.page')->with([
                                'error' => $this->translation->authMessages['email_not_verified'],
                                'title' => $this->translation->notification['failed'],
                                'content' => $this->translation->authMessages['email_not_verified'],
                            ]);
                        }
                        break;

                    default:
                        if ($auth->email_verified_at != null) {
                            activity()->causedBy(Auth::user())->performedOn(new User)->log($this->translation->authMessages['login_success']);
                            return redirect()->route('site.index')->with([
                                'success' => $this->translation->authMessages['login_success'],
                                'title' => $this->translation->notification['success'],
                                'content' => $this->translation->authMessages['login_success'],
                            ]);
                        } else {
                            Auth::logout();
                            activity()->causedBy(Auth::user())->performedOn(new User)->log($this->translation->authMessages['email_not_verified']);
                            return redirect()->route('resend.verification.page')->with([
                                'error' => $this->translation->authMessages['email_not_verified'],
                                'title' => $this->translation->notification['failed'],
                                'content' => $this->translation->authMessages['email_not_verified'],
                            ]);
                        }
                        break;
                }
            } else {
                throw new Exception($this->translation->authMessages["user_not_found"]);
            }
        } catch (\Throwable$th) {
            Auth::logout();
            $message = $th->getMessage();
            report($message);

            activity()->causedBy(Auth::user())->performedOn(new User)->log($th->getMessage());
            return redirect()->route('login.page')->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function logout()
    {
        return Auth::logout();
    }

    public function register_client(AuthFormRequest $request, $type)
    {
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new User)->log($request->validator->messages());
        }
        $request->validated();
        $client = $request->only(["name", "email", "password", "password_confirmation"]);

        DB::beginTransaction();
        try {
            switch ($type) {
                case 'customer':
                    $user_result = $this->user->StoreUser($client, 'customer');
                    $token_data = $this->token->StoreToken($user_result->id, $this->generator->GenerateWord());
                    $this->email->EmailVerification($user_result->email, $this->encryption->EncryptToken($token_data->token));
                    DB::commit();
                    activity()->causedBy(Auth::user())->performedOn(new User)->log($this->translation->newRegistrationMessage('email', $client['email']));
                    return redirect()->route('resend.verification.page');
                    break;

                default:
                    return redirect()->route('login.page');
                    break;
            }
        } catch (\Throwable$th) {
            DB::rollBack();
            $message = $th->getMessage();
            report($message);

            activity()->causedBy(Auth::user())->performedOn(new User)->log($message);
            return redirect()->route('register.page')->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function resend_verification(AuthFormRequest $request)
    {
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new User)->log($request->validator->messages());
        }
        $request->validated();
        $email = $request->only(['email']);

        DB::beginTransaction();
        try {
            $getUser = $this->user->GetUserByEmail($email['email']);
            $getToken = $this->token->StoreToken($getUser->id, $this->generator->GenerateWord());
            $this->email->EmailVerification($getUser->email, $this->encryption->EncryptToken($getToken->token));
            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new User)->log($this->translation->resendVerificationMessage('email', $email['email']));
            return redirect()->route('resend.verification.page')->with([
                'success' => $this->translation->authMessages['email_sent'],
            ]);
        } catch (\Throwable$th) {
            DB::rollBack();
            $message = $th->getMessage();
            report($message);

            activity()->causedBy(Auth::user())->performedOn(new User)->log($message);
            return redirect()->route('resend.verification.page')->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function verify($token)
    {
        DB::beginTransaction();
        try {
            $data_token = $this->token->GetUUIDByToken($this->encryption->DecryptToken($token));
            $dataUser = $this->user->GetUserByID($data_token->user_id);
            $dataUser->update([
                'email_verified_at' => date("Y-m-d H:i:s"),
            ]);
            $this->token->DeleteToken($dataUser->id);
            DB::commit();
            activity()->causedBy($dataUser->id)->performedOn(new User)->log($this->translation->authMessages['user_verified']);
            return redirect()->route('login.page')->with([
                'success' => $this->translation->authMessages['user_verified'],
            ]);
        } catch (\Throwable$th) {
            DB::rollBack();
            $message = $th->getMessage();
            report($message);

            activity()->causedBy(Auth::user())->performedOn(new User)->log($message);
            return redirect()->route('login.page')->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function forgot_password(AuthFormRequest $request)
    {
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new User)->log($request->validator->messages());
        }
        $request->validated();
        $email = $request->only(['email']);

        DB::beginTransaction();
        try {
            $getUser = $this->user->GetUserByEmail($email['email']);
            if (is_null($getUser)) {
                throw new Exception($this->translation->authMessages['user_not_found']);
            }
            $getToken = $this->token->StoreToken($getUser->id, $this->generator->GenerateWord());
            $this->email->EmailResetPassword($getUser->email, $this->encryption->EncryptToken($getToken->token));
            DB::commit();
            activity()->causedBy($getUser->id)->performedOn(new User)->log($this->translation->authMessages['request_forgot_password']);
            return redirect()->route('forgot.password.page')->with([
                'success' => $this->translation->authMessages['email_sent'],
            ]);
        } catch (\Throwable$th) {
            DB::rollBack();
            $message = $th->getMessage();
            report($message);

            activity()->causedBy(Auth::user())->performedOn(new User)->log($message);
            return redirect()->route('forgot.password.page')->with([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function reset_password(AuthFormRequest $request)
    {
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new User)->log($request->validator->messages());
        }
        $request->validated();
        $data = $request->only(['token', 'new_password']);
        DB::beginTransaction();
        try {
            $data_token = $this->token->GetUUIDByToken($this->encryption->DecryptToken($data["token"]));
            $dataUser = $this->user->GetUserByID($data_token->user_id);
            // $match_password = Hash::check($data['old_password'], $dataUser->password);
            $match_password = true;
            if ($match_password == true) {
                $dataUser->password = Hash::make($data['new_password']);
                $dataUser->save();
                DB::commit();
                activity()->causedBy($dataUser->id)->performedOn(new User)->log($this->translation->authMessages['password_change']);
                return redirect()->route('login.page')->with([
                    'success' => $this->translation->authMessages['password_change'],
                ]);
            } else {
                throw new Exception($this->translation->authMessages['password_not_match'], 1);
            }
        } catch (\Throwable$th) {
            DB::rollBack();
            $message = $th->getMessage();
            report($message);

            activity()->causedBy($dataUser->id)->performedOn(new User)->log($message);
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }

}
