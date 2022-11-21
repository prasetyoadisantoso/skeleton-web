<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class MetaFormRequest extends FormRequest
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
            case 'meta.store':
                return [
                    'name' => 'required|string|max:20',
                    'robot' => 'required|string',
                    'description' => 'required|string',
                    'keyword' => 'required|string',
                ];
                break;

            case 'meta.update':
                return [
                    'name' => 'required|string|max:20',
                    'robot' => 'required|string',
                    'description' => 'required|string',
                    'keyword' => 'required|string',
                ];
                break;

            default:
                # code...
                break;
        }
    }
}
