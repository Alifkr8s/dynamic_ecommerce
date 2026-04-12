<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
<<<<<<< HEAD
=======
use Illuminate\Contracts\Validation\ValidationRule;
>>>>>>> 53ee8e9e6af63cef39947ec0d1f997481c465bc0
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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
<<<<<<< HEAD
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
=======
     * @return array<string, ValidationRule|array<mixed>|string>
>>>>>>> 53ee8e9e6af63cef39947ec0d1f997481c465bc0
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
<<<<<<< HEAD
     * @throws \Illuminate\Validation\ValidationException
=======
     * @throws ValidationException
>>>>>>> 53ee8e9e6af63cef39947ec0d1f997481c465bc0
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
<<<<<<< HEAD
     * @throws \Illuminate\Validation\ValidationException
=======
     * @throws ValidationException
>>>>>>> 53ee8e9e6af63cef39947ec0d1f997481c465bc0
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
