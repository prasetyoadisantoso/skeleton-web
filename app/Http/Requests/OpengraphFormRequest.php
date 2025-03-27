<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class OpengraphFormRequest extends FormRequest
{
    public $validator;

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
            case 'opengraph.store':
                return [
                    'og_title' => 'required|string|unique:opengraphs|max:50',
                    'og_description' => 'required|string',
                    'og_type' => 'required|string',
                    'og_url' => 'required|string',
                    'og_image' => 'nullable',
                    'og_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ];
                break;

            case 'opengraph.update':
                return [
                    'og_title' => 'required|string|max:50',
                    'og_description' => 'required|string',
                    'og_type' => 'required|string',
                    'og_url' => 'required|string',
                    'og_image' => 'nullable',
                    'og_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
