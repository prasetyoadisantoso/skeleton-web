<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Validation\Validator;

class OpengraphFormRequest extends FormRequest
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
            case 'opengraph.store':
                return [
                    'name' => 'required|string|unique:opengraphs|max:50',
                    'title' => 'required|string',
                    'description' => 'required|string',
                    'url' => 'required|string',
                    'site_name' => 'required|string',
                    'image' => 'nullable',
                    'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'type' => 'required|string',
                ];
                break;

            case 'opengraph.update':
                return [
                    'name' => 'required|string|max:50',
                    'title' => 'required|string',
                    'description' => 'required|string',
                    'url' => 'required|string',
                    'site_name' => 'required|string',
                    'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'type' => 'required|string',
                ];
                break;

            default:
                # code...
                break;
        }
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }
}
