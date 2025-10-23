<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssistentStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email',
            'object' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'attachment' => 'nullable|array', // array opzionale dei file
            'attachments.*' => 'file|mimes:jpg,jpeg,png,gif,mp4,pdf,doc,docx|max:10240', // validazione singolo file
        ];
    }
}
