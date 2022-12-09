<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class AuthFormRequest extends FormRequest
{
    public $validator = null;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $route = Route::currentRouteName();

        switch ($route) {
            case 'test.client.register':
                return [
                    'name' => 'required|max:50',
                    'email' => 'required|email|unique:users,email',
                    'image' => 'nullable',
                    'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'phone' => "phone:ID",
                    'password' => 'required|same:password_confirmation',
                ];

                break;

            case 'test.client.verify':
                return [
                    'token' => 'required',
                ];

                break;

            case 'test.client.resend':
                return [
                    'email' => 'required|email',
                ];

            case 'test.client.resend.reset':
                return [
                    'email' => 'required|email',
                ];

            case 'test.client.check.reset':
                return [
                    'token' => 'required',
                ];
                break;

            case 'test.client.reset':
                return [
                    'old_password' => 'required',
                    'password' => 'required|same:password_confirmation',
                ];
                break;

            case 'test.reset.form':
                if (is_null($this->header('token'))) {
                    throw new Exception("Token is null");
                }
                return [
                ];
                break;

            case 'test.client.login':
                return [
                    "email" => "required|email",
                    "password" => "required",
                ];
                break;

            case 'test.admin.login':
                return [
                    "email" => "required|email",
                    "password" => "required",
                ];
                break;

            case 'register':
                return [
                    'name' => 'required|max:50',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|same:password_confirmation',
                ];
                break;

            case 'resend.verification':
                return [
                    'email' => 'required|email',
                ];
                break;

            case 'verify':
                return [
                    'token' => 'required',
                ];
                break;

            case 'forgot.password':
                return [
                    'email' => 'required|email',
                ];
                break;

            case 'reset.password':
                return [
                    'token' => 'required',
                    'old_password' => 'required',
                    'new_password' => 'required|same:confirm_password',
                ];
                break;

            case 'login':
                return [
                    'email' => 'required|email',
                    'password' => 'required',
                ];
                break;

            default:
                // code...
                break;
        }
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;

    }
}
