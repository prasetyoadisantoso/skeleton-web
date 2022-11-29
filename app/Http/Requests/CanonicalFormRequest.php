<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class CanonicalFormRequest extends FormRequest
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
            case 'canonical.store':
                return [
                    'name' => 'required|string|max:50',
                    'url' => 'required|string|max:50',
                ];
                break;

            case 'canonical.update':
                return [
                    'name' => 'required|string|max:50',
                    'url' => 'required|string|max:50',
                ];
                break;

            default:
                # code...
                break;
        }

    }
}
