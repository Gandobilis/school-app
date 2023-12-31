<?php

namespace App\Http\Requests\Banner;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'link' => 'required|url',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.title"] = "required|string|max:255";
            $rules["$locale.description"] = "required|string";
        }

        return $rules;
    }
}
