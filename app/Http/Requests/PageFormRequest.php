<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class PageFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Atur otorisasi sesuai kebutuhan
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
            case 'page.store':
                return [
                    'title' => 'required|string|unique_translation:pages|max:255',
                    'slug' => 'nullable|string|max:255',
                    'content' => 'nullable|string',
                    'layout_id' => 'nullable|uuid|exists:layouts,id',
                    'meta_id' => 'nullable|uuid|exists:metas,id',
                    'opengraph_id' => 'nullable|uuid|exists:opengraphs,id',
                    'canonical_id' => 'nullable|uuid|exists:canonicals,id',
                    'schemadata_id' => 'nullable|uuid|exists:schemadatas,id',
                ];
                break;

            case 'page.update':
                return [
                    'title' => 'required|string|max:255',
                    'slug' => 'nullable|string|max:255',
                    'content' => 'nullable|string',
                    'layout_id' => 'nullable|uuid|exists:layouts,id',
                    'meta_id' => 'nullable|uuid|exists:metas,id',
                    'opengraph_id' => 'nullable|uuid|exists:opengraphs,id',
                    'canonical_id' => 'nullable|uuid|exists:canonicals,id',
                    'schemadata_id' => 'nullable|uuid|exists:schemadatas,id',
                ];
                break;

            default:
                return [];
        }
    }
}
