<?php

namespace App\Http\Requests;

use App\Models\User;
<<<<<<< HEAD
=======
use Illuminate\Contracts\Validation\ValidationRule;
>>>>>>> 53ee8e9e6af63cef39947ec0d1f997481c465bc0
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
<<<<<<< HEAD
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
=======
     * @return array<string, ValidationRule|array<mixed>|string>
>>>>>>> 53ee8e9e6af63cef39947ec0d1f997481c465bc0
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }
}
