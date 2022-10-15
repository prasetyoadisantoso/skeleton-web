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

class TestAuthController extends Controller
{
    public function index(
        FileManagement $filemanagement,
        ResponseFormatter $response) {
        $filemanagement->Logging($response->successResponse([
            "Full Name" => "Insert full name",
            "Email" => "Insert email address",
            "Password" => "Insert password",
            "Password Confirmation" => "Insert password confirmation",
        ]));
    }

    public function register(
        ResponseFormatter $responseFormatter,
        FileManagement $fileManagement,
        TestAuthFormRequest $testRegister,
        Generator $generator,
        Encryption $encryption,
        User $user,
        Token $token,
        Email $email,
        $type
    ) {
        $testRegister->validated();
        $client = $testRegister->only(["name", "email", "image", "phone", "password", "password_confirmation"]);

        DB::beginTransaction();

        try {
            switch ($type) {
                case 'client':
                    $user_result = $user->StoreUser($client);
                    $token_data = $token->StoreToken($user_result->id, $generator->GenerateWord());
                    $email->EmailVerification($user_result->email, $encryption->EncryptToken($token_data->token));
                    $fileManagement->Logging($responseFormatter->successResponse("Success"));
                    DB::commit();
                    break;

                default:
                    $fileManagement->Logging($responseFormatter->successResponse("Redirect into login page"));
                    return redirect()->route('test.home', '', 302);
                    break;
            }
        } catch (\Throwable$th) {
            DB::rollback();
            $fileManagement->Logging($responseFormatter->errorResponse($th->getMessage(), "Failed"));
        }
    }

    public function verify(
        ResponseFormatter $responseFormatter,
        FileManagement $fileManagement,
        TestAuthFormRequest $testAuthFormRequest,
        Encryption $encryption,
        Token $token,
        User $user,
    ) {
        $testAuthFormRequest->validated();
        $getToken = $testAuthFormRequest->only(['token']);
        DB::beginTransaction();
        try {
            $data_token = $token->GetUUIDByToken($encryption->DecryptToken($getToken["token"]));
            $dataUser = $user->GetUserByID($data_token->user_id);
            $dataUser->update([
                'email_verified_at' => date("Y-m-d H:i:s"),
            ]);
            $token->DeleteToken($dataUser->id);
            DB::commit();
            $fileManagement->Logging($responseFormatter->successResponse($dataUser->name . " has been verified"));
        } catch (\Throwable$th) {
            DB::rollBack();
            $fileManagement->Logging($responseFormatter->errorResponse($th->getMessage()));
        }

    }

    public function resend_verification(
        TestAuthFormRequest $testAuthFormRequest,
        User $user,
        Encryption $encryption,
        Token $token,
        Generator $generator,
        Email $email,
        FileManagement $fileManagement,
        ResponseFormatter $responseFormatter
    )
    {
        $testAuthFormRequest->validated();
        $getRequest = $testAuthFormRequest->only(['email']);

        DB::beginTransaction();
        try {
            $getUser = $user->GetUserByEmail($getRequest['email']);
            $getToken = $token->StoreToken($getUser->id, $generator->GenerateWord());
            $email->EmailVerification($getUser->email, $encryption->EncryptToken($getToken->token));
            DB::commit();
            $fileManagement->Logging($responseFormatter->successResponse("Verification email has been sent"));
        } catch (\Throwable $th) {
            DB::rollBack();
            $fileManagement->Logging($responseFormatter->errorResponse("Verification not sent", $th->getMessage()));
        }
    }
}
