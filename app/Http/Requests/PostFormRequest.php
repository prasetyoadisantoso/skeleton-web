<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Route;

class PostFormRequest extends FormRequest
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
            case 'post.store':
                return [
                    'title' => 'required|string|unique_translation:posts|max:50',
                    'content' => 'required',
                    'feature_image' => 'nullable',
                    'feature_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ];
                break;

            case 'post.update':
                return [
                    'title' => 'required|string|max:50',
                    'content' => 'required',
                    'feature_image' => 'nullable',
                    'feature_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
