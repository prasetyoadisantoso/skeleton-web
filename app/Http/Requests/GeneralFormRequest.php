<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class GeneralFormRequest extends FormRequest
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
            case 'general.update.description':
                return [
                    'id' => 'required|uuid',
                    'site_title' => 'required|string',
                    'site_tagline' => 'required|string',
                    'url_address' => 'required|string',
                    'copyright' => 'required|string',
                    'cookies_concern' => 'required|string',
                ];
                break;

            case 'general.update.logo.favicon':
                return [
                    'site_logo' => 'nullable',
                    'site_logo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'site_favicon' => 'nullable',
                    'site_favicon.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ];
                break;

            default:
                # code...
                break;
        }
    }
}
