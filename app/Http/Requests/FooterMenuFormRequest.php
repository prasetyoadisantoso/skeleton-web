<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class FooterMenuFormRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $route = Route::currentRouteName();

        switch ($route) {
            case 'footermenus.store':
                return [
                    'name' => 'required|string|unique:header_menus|max:50',
                    'label' => 'required|string|max:50',
                    'url' => 'nullable|string|max:50',
                    'order' => 'required|integer',
                    'target' => 'nullable|string|max:20',
                    'is_active' => 'nullable|in:on',
                ];
            case 'footermenus.update':
                return [
                    'name' => 'required|string|max:50',
                    'label' => 'required|string|max:50',
                    'url' => 'nullable|string|max:50',
                    'order' => 'required|integer',
                    'target' => 'nullable|string|max:20',
                    'is_active' => 'nullable|in:on',
                ];
            default:
                return [];
        }
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
        ];
    }
}
