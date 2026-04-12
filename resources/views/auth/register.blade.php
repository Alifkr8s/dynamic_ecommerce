<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>

<title>Register</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

<div class="row justify-content-center mt-5">

<div class="col-md-4">

<div class="card shadow">

<div class="card-header bg-success text-white text-center">
<h4>Create Account</h4>
</div>

<div class="card-body">

<form method="POST" action="{{ route('register') }}">

@csrf

<div class="mb-3">

<label>Name</label>

<input type="text" name="name" class="form-control" required>

</div>

<div class="mb-3">

<label>Email</label>

<input type="email" name="email" class="form-control" required>

</div>

<div class="mb-3">

<label>Password</label>

<input type="password" name="password" class="form-control" required>

</div>

<div class="mb-3">

<label>Confirm Password</label>

<input type="password" name="password_confirmation" class="form-control" required>

</div>

<button class="btn btn-success w-100">

Register

</button>

</form>

<hr>

<div class="text-center">

<a href="{{ route('login') }}" class="btn btn-primary">

Already Registered? Login

</a>

</div>

</div>

</div>

</div>

</div>

</div>

</body>
</html>
=======
<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
>>>>>>> 53ee8e9e6af63cef39947ec0d1f997481c465bc0
