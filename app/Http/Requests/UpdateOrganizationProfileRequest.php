<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganizationProfileRequest extends FormRequest
{
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'org_name' => 'required|string|min:4|max:255',
            'contact_name' => 'required|string|min:2|max:255',
            'location' => 'nullable|string|max:255',
            'activity_description' => 'nullable|string',
            'adoption_summary' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
    
    public function messages()
    {
        return [
            'org_name.required' => '団体名は必須です',
            'org_name.min' => '団体名は3文字以上で入力してください',
            'org_name.max' => '団体名は255文字以内で入力してください',
            
            'contact_name.required' => '担当者名は必須です',
            'contact_name.min' => '担当者名は1文字以上で入力してください',
            'contact_name.max' => '担当者名は255文字以内で入力してください',

            'location.max' => '所在地は255文字以内で入力してください',
        ];
    }
}
