<?php

namespace App\Http\Requests;

use App\Models\CallCategory;
use App\Models\CustomerProject;
use Illuminate\Foundation\Http\FormRequest;

class CallStoreRequest extends FormRequest
{
    public CustomerProject $pivot;
    public CallCategory $category;

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
        return [
            'uuid' => ['required', 'uuid', 'exists:customer_project,uuid'],
            'title' => ['required', 'string'],
            'description' => ['string'],
            'from' => ['required', 'string'],
            'category' => ['required', 'string']
        ];
    }
}
