<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Route;

class CategoryFormRequest extends FormRequest
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
            case 'category.store':
                return [
                    'name' => 'required|string|unique_translation:categories|max:20',
                    'slug' => 'nullable|string|max:20',
                ];
                break;

            case 'category.update':
                return [
                    'name' => 'required|string|max:20',
                    'slug' => 'nullable|string|max:20',
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
