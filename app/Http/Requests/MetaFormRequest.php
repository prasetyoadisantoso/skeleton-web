<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Validation\Validator;

class MetaFormRequest extends FormRequest
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
            case 'meta.store':
                return [
                    'title' => 'required|string|unique:metas',
                    'description' => 'required|string',
                    'keyword' => 'required|string',
                ];
                break;

            case 'meta.update':
                return [
                    'title' => 'required|string',
                    'description' => 'required|string',
                    'keyword' => 'required|string',
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
