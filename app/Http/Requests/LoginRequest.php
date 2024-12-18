<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
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
            'account_number' => [
                'required',
                'string',
                'size:16',
                Rule::exists('users', 'account_number')->whereNull('deleted_at'),
                'exists:users,account_number'],
            'pin' => ['required', 'string', 'size:4'],
        ];

    }
}
