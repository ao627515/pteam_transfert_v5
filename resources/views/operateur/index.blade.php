@extends('layout')

@section('page', 'Opérateur')

@section('sub_page', 'Listing')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
    <x-alert></x-alert>
    <form action="{{ route('user.index') }}" method="GET" class="mb-4">
        @csrf
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Rechercher dans toutes les colonnes...">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
        </div>
    </form>
    <div class="mb-3 text-end">
        <a href="{{ route('user.create') }}" class="btn btn-primary">Ajouter</a>
    </div>
    <div class="card">
        <h2 class="text-center mb-3">Liste des opérateurs</h2>
        <div class="container">
            <form action="{{ route('user.index') }}" method="get" id="userForm">
                @csrf
                <div class="row align-items-center">
                    <div class="col-sm col-12">
                        <div class="form-check">
                            <input class="form-check-input chk" type="checkbox" value="administrateur" name="role[]" id="chkAdmin" @checked(in_array('administrateur', (array) request()->input('role')))>
                            <label class="form-check-label" for="chkAdmin">Administrateur</label>
                        </div>
                    </div>
                    <div class="col-sm col-12">
                        <div class="form-check">
                            <input class="form-check-input chk" type="checkbox" value="opérateur" name="role[]" id="chkOperateur" @checked(in_array('opérateur', (array) request()->input('role')))>
                            <label class="form-check-label" for="chkOperateur">Opérateur</label>
                        </div>
                    </div>
                    <div class="col-sm col-12">
                        <div class="form-check">
                            <input class="form-check-input chk" type="checkbox" value="1" name="est_connecte[]" id="chkConnecte" @checked(in_array(1 , (array) request()->input('est_connecte')))>
                            <label class="form-check-label" for="chkConnecte">Connecté</label>
                        </div>
                    </div>
                    <div class="col-sm col-12">
                        <div class="form-check">
                            <input class="form-check-input chk" type="checkbox" value="0" name="est_connecte[]" id="chkDeconnecte"  @checked(in_array(0 , (array) request()->input('est_connecte')))>
                            <label class="form-check-label" for="chkDeconnecte">Déconnecté</label>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="no-export">Statut</th>
                        <th class="text-center no-export">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->nom . ' ' . $user->prenom }}</td>
                            <td class="text-center">{{ $user->telephone }}</td>
                            <td class="text-center">{{ $user->email }}</td>
                            <td class="text-center">{{ $user->role }}</td>
                            <td class="text-center">
                                @if ($user->est_connecte)
                                    Connecter
                                @else
                                    Deconnecter
                                @endif
                            </td>
                            <td class="row gap-2">
                                <a href="{{ route('user.edit', $user) }}" class="btn btn-primary col-sm col-12">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('user.destroy', $user) }}" method="post" class="col-sm col-12 w-100 bg-danger"
                                    id="formDestroy">
                                    @csrf
                                    @method('delete')
                                    <button type="button" class="btn btn-danger w-100" data-toggle="modal"
                                        data-target="#modal-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <a href="{{ route('user.show', $user) }}" class="btn btn-info col-sm col-12">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <p class="text-center">Accune user trouver</p>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th>Nom</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Statut</th>
                        <th class="text-center no-export">
                            Action
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
        {{ $users->links() }}
        <!-- /.card-body -->
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
                    <p>Voullez vous supprimer cette opérateur ?</p>
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
                        "responsivePriority": 2 // Spécifie la priorité dans le mode responsive
                    }
                ],

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

        });

        $('#confirmBtnDanger').on('click', function() {
            // Soumettre le formulaire
            $('#formDestroy').submit();
        });

        $('.chk').on('change', function() {
                // Soumettre le formulaire
                $('#userForm').submit();
            });
    </script>
@endsection
