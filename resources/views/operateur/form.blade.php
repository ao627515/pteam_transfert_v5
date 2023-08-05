@php
    $villes = ['Aribinda', 'Bagré', 'Banfora', 'Batié', 'Bobo-Dioulasso', 'Bogandé', 'Bondigui', 'Boromo', 'Boulsa', 'Boussé', 'Dano', 'Dédougou', 'Diapaga', 'Diébougou', 'Djibo', 'Dori', "Fada N'gourma", 'Gaoua', 'Garango', 'Gayéri', 'Gorom-Gorom', 'Gourcy', 'Houndé', 'Kampti', 'Kantchari', 'Kaya', 'Kindi', 'Kokologo', 'Kombissiri', 'Kongoussi', 'Kordié', 'Koudougou', 'Kouka', 'Bam', 'Kouka', 'Banwa', 'Koupéla', 'Léo', 'Loropeni', 'Manga', 'Méguet', 'Mogtedo', 'Niangoloko', 'Nouna', 'Orodara', 'Ouagadougou', 'Ouahigouya', 'Ouargaye', 'Pama', 'Pissila', 'Pô', 'Pouytenga', 'Réo', 'Saponé', 'Sapouy', 'Sebba', 'Séguénéga', 'Sindou', 'Solenzo', 'Tangin Dassouri', 'Tenkodogo', 'Tikaré', 'Titao', 'Toma', 'Tougan', 'Villy', 'Yako', 'Ziniaré', 'Zorgo'];
@endphp
@extends('layout')

@section('page', 'Opérateur')

@if ($user->exists)
    @section('sub_page', 'Edit')
@else
    @section('sub_page', 'Create')
@endif

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
    <h3 class="text-center mt-5">{{ $user->exists ? 'Opérateur N°' . $user->id : 'Nouvelle opérateur' }}</h3>
    <form action="{{ $user->exists ? route('user.update', $user) : route('user.store') }}" method="post" class="vstack gap-3">
        @method($user->exists ? 'put' : 'post')
        @csrf
        <div class="container vstack gap-3">
            <x-forms.input name="nom" label="Nom" class="" type="text"
                value="{{ $user->exists ? $user->nom : '' }}" />
            <x-forms.input name="prenom" label="Prenom" class="" type="text"
                value="{{ $user->exists ? $user->prenom : '' }}" />
            <x-forms.input name="telephone" label="Tel" class="" type="text"
                value="{{ $user->exists ? $user->telephone : '' }}" />
            <x-forms.input name="email" label="Email" class="" type="email"
                value="{{ $user->exists ? $user->email : '' }}" />
            <div>
                <label for="role">Role</label>
                <select name="role" id="role" class="form-select">
                    <option value="administrateur" @selected($user->role == 'administrateur')>Administrateur</option>
                    <option value="opérateur" @selected($user->role == 'opérateur')>Opérateur</option>
                </select>
            </div>
            <div class="form-group">
                <label>Ville origine</label>
                <select class="form-control select2bs4" style="width: 100%;" name="localisation">
                    @foreach ($villes as $ville)
                        <option @selected($ville == $user->localisation) value="{{ $ville }}">{{ $ville }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if ($user->exists)
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                Modifier
            </button>
        @else
            <button class="btn btn-primary">
                Creer
            </button>
        @endif
    </form>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Voulez-vous modifer cette transaction ?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermé</button>
                    <button type="submit" class="btn btn-primary" id="confirmBtn">Enregistrer</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

@section('script')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Gérer l'événement de clic sur le bouton de validation
            $('#confirmBtn').on('click', function() {
                // Soumettre le formulaire
                $('form').submit();
            });
        });

        $(function() {
            $('.select2').select2();
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });
        });
    </script>
@endsection
