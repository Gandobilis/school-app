<?php

namespace App\Http\Requests\Lecturer;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            "linkedin" => "url",
            "image" => "required|mimes:png,jpg,jpeg",
            "course_ids" => "array",
            "course_ids.*" => "exists:courses,id"
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.first_name"] = "required|string|max:255";
            $rules["$locale.last_name"] = "required|string|max:255";
            $rules["$locale.position"] = "required|string|max:255";
            $rules["$locale.description"] = "required|string";
        }

        return $rules;
    }
}
