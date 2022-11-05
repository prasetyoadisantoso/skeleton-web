<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class UserFormRequest extends FormRequest
{
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
            case 'user.store':
                return [
                    'name' => 'required|max:50',
                    'email' => 'required|email',
                    'image' => 'nullable',
                    'role' => 'required',
                    'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                    'password' => 'required|same:confirm_password',
                ];

                break;

            case 'user.update':
                return [
                    'name' => 'required|max:50',
                    'email' => 'required|email',
                    'image' => 'nullable',
                    'role' => 'required',
                    'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                    'password' => 'same:confirm_password',
                ];

                break;

            default:
                // code...
                break;
        }
    }
}
