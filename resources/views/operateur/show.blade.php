@extends('layout')

@section('page', 'Opérateur')

@section('sub_page', "Show")

@section('content')
    <section style="background-color: #eee;">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp"
                                alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 class="my-3">{{ $user->nom. ' ' . $user->prenom }}</h5>
                            <p class="text-muted mb-1">{{ Str::ucfirst( $user->role ) }}</p>
                            <p class="text-muted mb-4">{{ $user->email }}</p>
                            <div class="d-flex justify-content-center mb-2">
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button class="btn btn-primary">Déconnextion</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Full Name</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $user->nom. ' ' . $user->prenom }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Email</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $user->email }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Phone</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $user->telephone }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Localisation</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $user->localisation }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <a href="{{ route('password.request') }}" class="link" >Changer le mot de passe</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
