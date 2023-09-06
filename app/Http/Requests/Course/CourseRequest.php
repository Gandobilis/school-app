<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            "image" => "required|mimes:png,jpg,jpeg",
            "lecturer_ids" => "array"
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.title"] = "required|string|max:255";
            $rules["$locale.text"] = "required|string|max:255";
            $rules["$locale.description"] = "required|string";
        }

        return $rules;
    }
}
