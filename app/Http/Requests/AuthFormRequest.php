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
