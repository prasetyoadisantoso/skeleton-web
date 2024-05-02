<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Validation\Validator;

class MediaLibraryFormRequest extends FormRequest
{
    public $validator = null;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $route = Route::currentRouteName();

        switch ($route) {
            case 'media-library.store':
                return [
                    'title' => 'nullable|string',
                    'information' => 'nullable|string',
                    'description' => 'nullable|string',
                    'media-files' => 'required|file|mimes:jpg,jpeg,png,mp3,mp4,pdf|max:50000'
                ];
                break;

            case 'media-library.update':
                return [
                    'title' => 'nullable|string',
                    'information' => 'nullable|string',
                    'description' => 'nullable|string',
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
