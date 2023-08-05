@extends('layout')

@section('content')
    <x-alert />
    <div class="row">
        <div class="col" id="transaction-show">
            <h1 class="text-center mb-5">Transaction N°{{ $transaction->transaction_id }}</h1>

            <div class="row">
                <div class="col-12 col-sm">
                    <h2 class="text-center">Expeditaire</h2>
                    <table class="table table-stried">
                        <tr>
                            <th>Nom</th>
                            <td>{{ $transaction->nom_expediteur }}</td>
                        </tr>
                        <tr>
                            <th>Prenom</th>
                            <td>{{ $transaction->prenom_expediteur }}</td>
                        </tr>
                        <tr>
                            <th>Tel</th>
                            <td>{{ $transaction->telephone_expediteur }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-12 col-sm">
                    <h2 class="text-center">Bénéficiaire</h2>
                    <table class="table table-stried text-center">
                        <tr>
                            <th>Nom</th>
                            <td>{{ $transaction->nom_beneficiaire }}</td>
                        </tr>
                        <tr>
                            <th>Prenom</th>
                            <td>{{ $transaction->prenom_beneficiaire }}</td>
                        </tr>
                        <tr>
                            <th>Tel</th>
                            <td>{{ $transaction->telephone_beneficiaire }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row d-sm-none">
                <table class="col-12  text-center table">
                    <tr>
                        <th>Ville</th>
                    </tr>
                    <tr>
                        <td>{{ $transaction->ville_origine . ' → ' . $transaction->ville_destinataire }}</td>
                    </tr>
                </table>
                <table class="col-12  text-center table">
                    <tr>
                        <th>Date de transfert</th>
                    </tr>
                    <tr>
                        <td>{{ $transaction->date_transfert }}</td>
                    </tr>
                </table>
                <table class="col-12  text-center table">
                    <tr>
                        <th>Montant</th>
                    </tr>
                    <tr>
                        <td>{{ number_format($transaction->montant, 0, '.', ' ') }}</td>
                    </tr>
                </table>
                <table class="col-12  text-center table">
                    <tr>
                        <th>Code Retrait</th>
                    </tr>
                    <tr>
                        <td>{{ $transaction->code_retrait }}</td>
                    </tr>
                </table>
                <table class="col-12  text-center table">
                    <tr>
                        <th>Date Retrait</th>
                    </tr>
                    <tr>
                        <td>{{ $transaction->date_retrait }}</td>
                    </tr>
                </table>
                <table class="col-12  text-center table">
                    <tr>
                        <th>Etat</th>
                    </tr>
                    <tr>
                        <td>
                            @if ($transaction->etat == 1)
                                En cours
                            @elseif ($transaction->etat == 2)
                                Retirer
                            @else
                                Annuler
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="row d-none d-sm-block">
                <h2 class="text-center">Transaction</h2>
                <table class="table text-center">
                    <thead>
                        <th>Ville</th>
                        <th>Date de transfert</th>
                        <th>Montant</th>
                        <th>Code Retrait</th>
                        <th>Date Retrait</th>
                        <th>Etat</th>
                    </thead>
                    <tbody>
                        <td>{{ $transaction->ville_origine . ' → ' . $transaction->ville_destinataire }}</td>
                        <td>{{ $transaction->date_transfert }}</td>
                        <td>{{ number_format($transaction->montant, 0, '.', ' ') }}</td>
                        <td>{{ $transaction->code_retrait }}</td>
                        <td>{{ $transaction->date_retrait }}</td>
                        <td>
                            @if ($transaction->etat == 1)
                                En cours
                            @elseif ($transaction->etat == 2)
                                Retirer
                            @else
                                Annuler
                            @endif
                        </td>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-sm-3 col-12">
            <div class="accordion mt-5" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Action
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row vstack gap-3">
                                @if ($transaction->etat == 1)
                                    <form action="{{ route('transaction.cancel', $transaction) }}" method="post"
                                        class="col bg-warning" id="formCancel">
                                        @csrf
                                        <button type="button" class="btn btn-warning w-100" data-toggle="modal"
                                            data-target="#modal-warning">
                                            Annuler
                                        </button>
                                    </form>
                                    <form action="{{ route('transaction.withdrawal', $transaction) }}" method="post"
                                        class="col bg-success" id="formWithdrawal">
                                        @csrf
                                        <button type="button" class="btn btn-success w-100" data-toggle="modal"
                                            data-target="#modal-success">
                                            Retrait
                                        </button>
                                    </form>
                                @endif

                                @can('delete', $transaction)
                                    <form action="{{ route('transaction.destroy', $transaction) }}" method="post"
                                        class="col bg-danger" id="formDestroy">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn btn-danger w-100" data-toggle="modal"
                                            data-target="#modal-danger">
                                            Supprimer
                                        </button>
                                    </form>
                                @endcan
                                @can('update', $transaction)
                                    <a href="{{ route('transaction.edit', $transaction) }}" class="btn btn-primary">Modifer</a>
                                @endcan

                                <a href="{{ route('transaction.print', $transaction) }}" class="btn btn-secondary">Imprimer</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-danger">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Danger Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Voullez vous supprimer cette transaction ?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Non</button>
                    <button type="button" class="btn btn-outline-light" id="confirmBtnDanger">Oui</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-warning">
        <div class="modal-dialog">
            <div class="modal-content bg-warning">
                <div class="modal-header">
                    <h4 class="modal-title">Warning Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Voullez-vous Annuler cette transaction ?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Non</button>
                    <button type="button" class="btn btn-outline-dark" id="confirmBtnWarning">Oui</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-success">
        <div class="modal-dialog">
            <div class="modal-content bg-success">
                <div class="modal-header">
                    <h4 class="modal-title">Success</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Voullez-vous effectuer un retrait ?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Non</button>
                    <button type="button" class="btn btn-outline-light" id="confirmBtnSuccess">Oui</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection


@section('script')
    <script>
        $(document).ready(function() {
            // Gérer l'événement de clic sur le bouton de validation
            $('#confirmBtnWarning').on('click', function() {
                // Soumettre le formulaire
                $('#formCancel').submit();
            });
            $('#confirmBtnDanger').on('click', function() {
                // Soumettre le formulaire
                $('#formDestroy').submit();
            });
            $('#confirmBtnSuccess').on('click', function() {
                // Soumettre le formulaire
                $('#formWithdrawal').submit();
            });
        });
    </script>
@endsection
