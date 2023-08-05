@extends('layout')

@section('page', 'Mot de passe oublié')

@section('sub_page', 'mail')

@section('content')
    <div class="container">
        <form action="{{ route('password.email') }}" method="post" class="vstack gap-3">
            @csrf
            <x-forms.input name="email" label="Email" required/>
            <button class="btn btn-primary w-25 m-auto">Valider</button>
        </form>
    </div>
@endsection
