<?php

namespace App\Http\Requests\Lecturer;

use Illuminate\Foundation\Http\FormRequest;

class LecturerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            "linkedin" => "required|string|max:255",
            "image" => "required|mimes:png,jpg,jpeg"
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = "required|string|max:255";
            $rules["$locale.position"] = "required|string|max:255";
            $rules["$locale.description"] = "required|string";
        }

        return $rules;
    }
}
