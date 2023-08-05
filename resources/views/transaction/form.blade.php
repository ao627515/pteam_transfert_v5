@extends('layout')

@php
    $villes = ['Aribinda', 'Bagré', 'Banfora', 'Batié', 'Bobo-Dioulasso', 'Bogandé', 'Bondigui', 'Boromo', 'Boulsa', 'Boussé', 'Dano', 'Dédougou', 'Diapaga', 'Diébougou', 'Djibo', 'Dori', "Fada N'gourma", 'Gaoua', 'Garango', 'Gayéri', 'Gorom-Gorom', 'Gourcy', 'Houndé', 'Kampti', 'Kantchari', 'Kaya', 'Kindi', 'Kokologo', 'Kombissiri', 'Kongoussi', 'Kordié', 'Koudougou', 'Kouka', 'Bam', 'Kouka', 'Banwa', 'Koupéla', 'Léo', 'Loropeni', 'Manga', 'Méguet', 'Mogtedo', 'Niangoloko', 'Nouna', 'Orodara', 'Ouagadougou', 'Ouahigouya', 'Ouargaye', 'Pama', 'Pissila', 'Pô', 'Pouytenga', 'Réo', 'Saponé', 'Sapouy', 'Sebba', 'Séguénéga', 'Sindou', 'Solenzo', 'Tangin Dassouri', 'Tenkodogo', 'Tikaré', 'Titao', 'Toma', 'Tougan', 'Villy', 'Yako', 'Ziniaré', 'Zorgo'];
@endphp

@section('page', 'Transaction')

@if ($transaction->exists)
    @section('sub_page', 'Edit')
@else
    @section('sub_page', 'Transfert')
@endif

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
    <x-alert></x-alert>
    <h1 class="text-center mb-3">
        @if ($transaction->exists)
            Transaction N°{{ $transaction->id }}
        @else
            Nouvelle Transaction
        @endif
    </h1>
    <form action="{{ $transaction->exists ? route('transaction.update', $transaction) : route('transaction.store') }}"
        method="post" class="vstack gap-4">
        @csrf
        @method($transaction->exists ? 'put' : 'post')

        <div class="row">
            <div class="col">
                <h3 class="text-center">Expediteur</h3>
                <x-forms.input name="nom_expediteur" label="Nom" type="text"
                    value="{{$transaction->exists ? $transaction->nom_expediteur : '' }}" />
                <x-forms.input name="prenom_expediteur" label="Prenom" type="text"
                    value="{{$transaction->exists ?  $transaction->prenom_expediteur : '' }}" />
                <x-forms.input name="telephone_expediteur" label="Telephone" type="text"
                    value="{{$transaction->exists ? $transaction->telephone_expediteur : '' }}" />
            </div>
            <div class="col">
                <h3 class="text-center">Bénéficiaire</h3>
                <x-forms.input name="nom_beneficiaire" label="Nom" type="text"
                    value="{{$transaction->exists ?  $transaction->nom_beneficiaire : '' }}" />
                <x-forms.input name="prenom_beneficiaire" label="Prenom" type="text"
                    value="{{$transaction->exists ?  $transaction->prenom_beneficiaire : ''}}" />
                <x-forms.input name="telephone_beneficiaire" label="Telephone" type="text"
                    value="{{$transaction->exists ?  $transaction->telephone_beneficiaire : ''}}" />
            </div>
        </div>
        <input type="hidden" name="user_id" value="{{ $transaction->exists ? $transaction->user->id : $user->id }}">
        <div class="mt-2">
            <h3 class="text-center">Transaction</h3>
            <div class="row">
                <div class="form-group col-sm col-12">
                    <label>Ville origine</label>
                    <select class="form-control select2bs4" style="width: 100%;" name="ville_origine">
                        @foreach ($villes as $ville)
                            <option @selected($ville == $transaction->ville_origine)>{{ $ville }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm col-12">
                    <label>Ville de destination</label>
                    <select class="form-control select2bs4" style="width: 100%;" name="ville_destinataire">
                        @foreach ($villes as $ville)
                            <option @selected($ville == $transaction->ville_destinataire)>{{ $ville }}</option>
                        @endforeach
                    </select>
                </div>

                <x-forms.input class="form-group col-sm col-12" name="montant" label="Montant" type="number"
                    value="{{ $transaction->montant }}" />
            </div>
        </div>

        @if ($transaction->exists)
            <button type="button" class="btn btn-primary w-100 mt-3" data-toggle="modal" data-target="#modal-default">
                Modifier
            </button>
        @else
            <button class="btn btn-primary w-100 mt-3">
                Transfert
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
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
@endsection
