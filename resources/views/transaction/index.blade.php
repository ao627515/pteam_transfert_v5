@extends('layout')

@section('page', 'Transaction')

@section('sub_page', 'Listing')

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
    <x-alert />
    <form action="{{ route('transaction.index') }}" method="GET" class="mb-4">
        @csrf
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Rechercher dans toutes les colonnes...">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
        </div>
    </form>
    <div class="mb-3 d-flex justify-content-end">
        <a href="{{ route('transaction.create') }}" class="btn btn-primary">Transfert</a>
    </div>
    <div class="card">
        <h2 class="text-center">Liste des transactions</h2>
        <div class="container">
            <form action="{{ route('transaction.index') }}" method="get" id="user_transactionsForm">
                <div class="row">
                    <div class="col-sm-2 col-12">
                        @csrf
                    </div>
                    <div class="col-sm-2 col-12">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    </div>
                    <div class="form-check form-switch col-sm-4 col-12">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault"
                            name="user_transactions" @checked(request()->input('user_transactions'))>
                        <label class="form-check-label" for="flexSwitchCheckDefault">Mes transactions</label>
                    </div>
                    <div class="col-sm-4 col-12">
                        <select class="form-select" aria-label="Default select example" name="etat" id="etatSelect">
                            <option value="0" @selected((request('etat') == 0))>Tout les états</option>
                            <option value="1" @selected((request('etat') == 1))>En cours</option>
                            <option value="2" @selected((request('etat') == 2))>Retirer</option>
                            <option value="3" @selected((request('etat') == 3))>Annuler</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Expediteur</th>
                        <th>Bénéficiaire</th>
                        <th>ville origine → destinataire</th>
                        <th>code retrait</th>
                        <th>montant</th>
                        <th>etat</th>
                        <th>date transfert</th>
                        <th class="text-center no-export">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->nom_expediteur . ' ' . $transaction->prenom_expediteur }}</td>
                            <td>{{ $transaction->nom_beneficiaire . ' ' . $transaction->prenom_beneficiaire }}</td>
                            <td class="text-center">
                                {{ $transaction->ville_origine . ' → ' . $transaction->ville_destinataire }}
                            </td>
                            <td class="text-center">{{ $transaction->code_retrait }}</td>
                            <td class="text-center">{{ number_format((float) $transaction->montant, 0, '.', ' ') }}</td>
                            <td class="text-center">
                                @if ($transaction->etat == 1)
                                    En cours
                                @elseif ($transaction->etat == 2)
                                    Retirer
                                @else
                                    Annuler
                                @endif
                            </td>
                            <td class="text-center">{{ $transaction->date_transfert }}</td>
                            <td class="row gap-2">
                                @can('update', $transaction)
                                    <a href="{{ route('transaction.edit', $transaction) }}"class="btn btn-primary col"
                                        style="title: aziz">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                @endcan
                                <a href="{{ route('transaction.show', $transaction) }}" class="btn btn-info col">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <p class="text-center">Accune transaction trouver</p>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th>Expediteur</th>
                        <th>Bénéficiaire</th>
                        <th>ville origine → destinataire</th>
                        <th>code retrait</th>
                        <th>montant</th>
                        <th>etat</th>
                        <th>date transfert</th>
                        <th class="text-center no-export">
                            Action
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
        {{ $transactions->links() }}
        <!-- /.card-body -->
    </div>
@endsection


@section('script')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "paging": false,
                'ordering': false,
                "info": false,
                "columnDefs": [{
                    "targets": 5, // Index de la colonne "Action" (commence à zéro)
                    "responsivePriority": 5 // Spécifie la priorité dans le mode responsive
                }],

                "buttons": [{
                        "extend": "copy",
                        "exportOptions": {
                            "columns": ":not(.no-export)" // Exclut les colonnes avec la classe "no-export"
                        }
                    },
                    {
                        "extend": "csv",
                        "exportOptions": {
                            "columns": ":not(.no-export)" // Exclut les colonnes avec la classe "no-export"
                        }
                    },
                    {
                        "extend": "excel",
                        "exportOptions": {
                            "columns": ":not(.no-export)" // Exclut les colonnes avec la classe "no-export"
                        }
                    },
                    {
                        "extend": "pdf",
                        "exportOptions": {
                            "columns": ":not(.no-export)" // Exclut les colonnes avec la classe "no-export"
                        }
                    },
                    {
                        "extend": "print",
                        "exportOptions": {
                            "columns": ":not(.no-export)" // Exclut les colonnes avec la classe "no-export"
                        }
                    },
                    "colvis"
                ]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $('#flexSwitchCheckDefault').on('click', function() {
                // Soumettre le formulaire
                $('#user_transactionsForm').submit();
            });

            $('#etatSelect').on('change', function() {
                // Soumettre le formulaire
                $('#user_transactionsForm').submit();
            });

        });
    </script>
@endsection
