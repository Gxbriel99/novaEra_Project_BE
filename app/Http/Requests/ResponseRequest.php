<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResponseRequest extends FormRequest
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
            'idTicket' => 'required|integer|exists:assistence_request,idTicket',
            'response' => 'nullable|string|max:500',
            'message' => 'nullable|string|max:500',
            'attachment' => 'nullable|array',
            'attachment.*' => 'file|mimes:jpg,jpeg,png,gif,mp4,pdf,doc,docx|max:10240',
        ];
    }
}
