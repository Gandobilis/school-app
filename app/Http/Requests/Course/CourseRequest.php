<?php

namespace App\Http\Requests\Course;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            "image" => "required|mimes:png,jpg,jpeg",
            "syllabus" => "required|mimes:pdf",
            "duration" => "required|numeric",
            "fee" => "required|numeric",
            "old_fee" => "numeric",
            "start_date" => "required|date",
            "lecturer_ids" => "array",
            "lecturer_ids.*' => 'exists:lecturers,id"
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.title"] = "required|string|max:255";
            $rules["$locale.short_description"] = "required|string|max:255";
            $rules["$locale.detailed_description"] = "required|string";
        }

        return $rules;
    }
}
