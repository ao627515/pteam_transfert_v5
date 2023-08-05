@extends('layout')

@section('page', 'Mot de passe oublier')

@section('sub_page', 'Reset')

@section('content')
    <form action="{{ route('password.store') }}" method="post">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <x-forms.input label="Email" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />

        <x-forms.input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" label="Mot de passe" />

        <x-forms.input label="" id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />

        <div class="flex items-center justify-end mt-4">
            <button class="btn btn-primary">
                Reset password
            </button>
        </div>
    </form>
@endsection
