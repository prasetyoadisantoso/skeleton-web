<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestAuthFormRequest;
use App\Models\Token;
use App\Models\User;
use App\Services\Email;
use App\Services\Encryption;
use App\Services\FileManagement;
use App\Services\Generator;
use App\Services\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestAuthController extends Controller
{
    protected $fileManagement, $responseFormatter, $generator, $encryption, $user, $token, $email;

    public function __construct(
        FileManagement $fileManagement,
        ResponseFormatter $responseFormatter,
        Generator $generator,
        Encryption $encryption,
        User $user,
        Token $token,
        Email $email,
    ) {
        $this->responseFormatter = $responseFormatter;
        $this->fileManagement = $fileManagement;
        $this->generator = $generator;
        $this->encryption = $encryption;
        $this->user = $user;
        $this->token = $token;
        $this->email = $email;
    }

    public function login_page()
    {
        $this->fileManagement->Logging($this->responseFormatter->successResponse([
            "Email" => "Email...",
            "Password" => "Password...",
            "Remember Me" => "Checkbox",
        ]));
    }

    public function register_page()
    {
        $this->fileManagement->Logging($this->responseFormatter->successResponse([
            "Full Name" => "Insert full name",
            "Email" => "Insert email address",
            "Password" => "Insert password",
            "Password Confirmation" => "Insert password confirmation",
        ]));
    }

    public function register(
        TestAuthFormRequest $testRegister,
        $type
    ) {
        $testRegister->validated();
        $client = $testRegister->only(["name", "email", "image", "phone", "password", "password_confirmation"]);

        DB::beginTransaction();

        try {
            switch ($type) {
                case 'client':
                    $user_result = $this->user->StoreUser($client);
                    $token_data = $this->token->StoreToken($user_result->id, $this->generator->GenerateWord());
                    $this->email->EmailVerification($user_result->email, $this->encryption->EncryptToken($token_data->token));
                    $this->fileManagement->Logging($this->responseFormatter->successResponse("Success"));
                    DB::commit();
                    break;

                default:
                    $this->fileManagement->Logging($this->responseFormatter->successResponse("Redirect into login page"));
                    return redirect()->route('test.home', '', 302);
                    break;
            }
        } catch (\Throwable$th) {
            DB::rollback();
            $this->fileManagement->Logging($this->responseFormatter->errorResponse($th->getMessage(), "Failed"));
        }
    }

    public function verify_page()
    {
        $this->fileManagement->Logging($this->responseFormatter->successResponse([
            "Email" => "Email Address",
        ]));
    }

    public function verify(
        TestAuthFormRequest $testAuthFormRequest
    ) {
        $testAuthFormRequest->validated();
        $getToken = $testAuthFormRequest->only(['token']);
        DB::beginTransaction();
        try {
            $data_token = $this->token->GetUUIDByToken($this->encryption->DecryptToken($getToken["token"]));
            $dataUser = $this->user->GetUserByID($data_token->user_id);
            $dataUser->update([
                'email_verified_at' => date("Y-m-d H:i:s"),
            ]);
            $this->token->DeleteToken($dataUser->id);
            DB::commit();
            $this->fileManagement->Logging($this->responseFormatter->successResponse($dataUser->name . " has been verified"));
        } catch (\Throwable$th) {
            DB::rollBack();
            $this->fileManagement->Logging($this->responseFormatter->errorResponse($th->getMessage()));
        }

    }

    public function resend_verification(
        TestAuthFormRequest $testAuthFormRequest,
    ) {
        $testAuthFormRequest->validated();
        $getRequest = $testAuthFormRequest->only(['email']);

        DB::beginTransaction();
        try {
            $getUser = $this->user->GetUserByEmail($getRequest['email']);
            $getToken = $this->token->StoreToken($getUser->id, $this->generator->GenerateWord());
            $this->email->EmailVerification($getUser->email, $this->encryption->EncryptToken($getToken->token));
            DB::commit();
            $this->fileManagement->Logging($this->responseFormatter->successResponse("Verification email has been sent"));
        } catch (\Throwable$th) {
            DB::rollBack();
            $this->fileManagement->Logging($this->responseFormatter->errorResponse("Verification not sent", $th->getMessage()));
        }
    }

    public function reset_password_page()
    {
        $this->fileManagement->Logging($this->responseFormatter->successResponse([
            "Email" => "Email Address",
        ]));
    }

    public function resend_reset_password(TestAuthFormRequest $test)
    {
        $test->validated();
        $getRequest = $test->only(['email']);
        try {
            $getUser = $this->user->GetUserByEmail($getRequest['email']);
            $getToken = $this->token->StoreToken($getUser->id, $this->generator->GenerateWord());
            $this->email->EmailVerification($getUser->email, $this->encryption->EncryptToken($getToken->token));
            DB::commit();
            $this->fileManagement->Logging($this->responseFormatter->successResponse("Reset password has been sent"));
        } catch (\Throwable$th) {
            DB::rollBack();
            $this->fileManagement->Logging($this->responseFormatter->errorResponse("Reset password not sent", $th->getMessage()));
        }
    }

    public function check_reset_password(
        TestAuthFormRequest $testAuthFormRequest
    ) {
        $testAuthFormRequest->validated();
        $getToken = $testAuthFormRequest->only(['token']);

        $data_token = $this->token->GetUUIDByToken($this->encryption->DecryptToken($getToken["token"]));
        $dataUser = $this->user->GetUserByID($data_token->user_id);

        try {
            $data_token = $this->token->GetUUIDByToken($this->encryption->DecryptToken($getToken["token"]));
            $dataUser = $this->user->GetUserByID($data_token->user_id);
            if (is_null($dataUser)) {
                throw new Exception("Token invalid");
            } else {
                $check = redirect()->route('test.reset.form')->with([
                    "token" => $getToken,
                ]);
                $this->fileManagement->Logging($this->responseFormatter->successResponse($check, "Redirect into update password form page"));
            }
        } catch (\Throwable$th) {
            $this->fileManagement->Logging($this->responseFormatter->errorResponse($th->getMessage()));
        }
    }

    public function reset_password_form(TestAuthFormRequest $test)
    {
        if (is_null($test->header('token'))) {
            redirect()->route('test.reset.home')->with([
                'message' => 'Token is invalid',
            ]);
        } else {
            $this->fileManagement->Logging($this->responseFormatter->successResponse([
                "token" => $test->header('token'),
                "Old Password" => "Old password",
                "New Password" => "New password",
                "Confirm New Password" => "Confirm new password",
            ]));
        }
    }

    public function reset_password(TestAuthFormRequest $test)
    {
        $test->validated();
        $data = $test->only(['token', 'old_password', 'password']);
        DB::beginTransaction();
        try {
            $data_token = $this->token->GetUUIDByToken($this->encryption->DecryptToken($data["token"]));
            $dataUser = $this->user->GetUserByID($data_token->user_id);
            $match_password = Hash::check($data['old_password'], $dataUser->password);
            if($match_password == true) {
                $dataUser->password = $data['password'];
                $dataUser->save();
                DB::commit();
                $this->fileManagement->Logging($this->responseFormatter->successResponse($dataUser, "Password Updated"));
            } else {
                throw new Exception("Error Processing Request", 1);
            }
        } catch (\Throwable$th) {
            DB::rollBack();
            $this->fileManagement->Logging($this->responseFormatter->errorResponse($th->getMessage()));
        }

    }
}
