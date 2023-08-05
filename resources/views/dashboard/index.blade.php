@extends('layout')

@section('page', 'Dashboard')

@section('sub_page', 'Dashboard')

@section('css')

@endsection

@section('content')
    <div class="container-fluid">
        <!-- Votre contenu ici -->
        <form action="{{ route('dashboard.index') }}" method="get" id="yearSearch">
            @csrf
            <div class="form-group">
                <label for="annee">Sélectionner une année :</label>
                <select class="form-control" name="annee" id="annee">
                    @foreach ($years as $year)
                        <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
        </form>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#operateurs" role="tab">Opérateurs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#transactions" role="tab">Transactions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#combine" role="tab">Opérateurs & Transactions</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content p-3">
            <!-- Onglet pour les opérateurs -->
            <div class="tab-pane active" id="operateurs" role="tabpanel">
                <div class="row">
                    <!-- Nombre total d'opérateurs enregistrés -->
                    <div class="col-lg-3 col-md-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{ $totalUsers }}</h3>
                                <p>Nombre total d'opérateurs enregistrés</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Nombre d'opérateurs connectés actuellement -->
                    <div class="col-lg-3 col-md-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $connectedUsers }}</h3>
                                <p>Nombre d'opérateurs connectés actuellement</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Nombre d'opérateurs par rôle -->
                    <div class="col-lg-3 col-md-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $adminUsers }}</h3>
                                <p>Nombre d'administrateurs</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-shield"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $operatorUsers }}</h3>
                                <p>Nombre d'opérateurs</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Nombre d'opérateurs ayant vérifié leur adresse e-mail -->
                    <div class="col-lg-3 col-md-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $verifiedUsers }}</h3>
                                <p>Nombre d'opérateurs ayant vérifié leur adresse e-mail</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-envelope-open"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Graphique Nombre d'opérateurs inscrits par mois -->
                <div class="card">
                    <div class="card-header">
                        Nombre d'opérateurs inscrits par mois
                    </div>
                    <div class="card-body">
                        <canvas id="usersByMonthChart" height="200"></canvas>
                    </div>
                </div>

                <!-- Graphique Nombre d'opérateurs par localisation (ville) -->
                <div class="card">
                    <div class="card-header">
                        Nombre d'opérateurs par localisation (ville)
                    </div>
                    <div class="card-body">
                        <canvas id="usersByLocationChart" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Onglet pour les transactions -->
            <div class="tab-pane" id="transactions" role="tabpanel">
                <div class="row">
                    <!-- Nombre total de transactions effectuées -->
                    <div class="col-lg-3 col-md-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{ $totalTransactions }}</h3>
                                <p>Nombre total de transactions effectuées</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-exchange-alt"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Nombre de transactions annulées -->
                    <div class="col-lg-3 col-md-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $cancelledTransactions }}</h3>
                                <p>Nombre de transactions annulées</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-times-circle"></i>
                            </div>
                        </div>
                    </div>
                    <!-- Nombre de transactions en cours -->
                    <div class="col-lg-3 col-md-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ count($ongoingTransactions) }}</h3>
                                <p>Nombre de transactions en cours</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-spinner"></i>
                            </div>
                        </div>
                    </div>
                    <!-- Nombre de transactions réussies -->
                    <div class="col-lg-3 col-md-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $successfulTransactions }}</h3>
                                <p>Nombre de transactions réussies</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Montant total transféré via toutes les transactions -->
                    <div class="col-lg-3 col-md-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totalTransferredAmount }}</h3>
                                <p>Montant total transféré via toutes les transactions</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                    </div>
                    <!-- Montant des transactions annulées -->
                    <div class="col-lg-3 col-md-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $cancelledAmount }}</h3>
                                <p>Montant des transactions annulées</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                    <!-- Montant total des transferts en cours -->
                    <div class="col-lg-3 col-md-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ number_format($ongoingAmount, 2, ',', ' ') }} FCFA</h3>
                                <p>Montant total des transferts en cours</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-money-check-alt"></i>
                            </div>
                        </div>
                    </div>
                    <!-- Montant des transactions réussies -->
                    <div class="col-lg-3 col-md-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $successfulAmount }}</h3>
                                <p>Montant des transactions réussies</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                    </div>


                    <!-- Montant moyen des transactions -->
                    <div class="col-lg-3 col-md-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $averageAmount }}</h3>
                                <p>Montant moyen des transactions</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Graphique Nombre de transactions par mois -->
                <div class="card">
                    <div class="card-header">
                        Nombre de transactions par mois
                    </div>
                    <div class="card-body">
                        <canvas id="transactionsByMonthChart" height="200"></canvas>
                    </div>
                </div>
                <!-- Nouvelle section pour les statistiques par ville d'origine et destination -->
                <div class="card">
                    <div class="card-header">
                        Nombre de transactions par ville d'origine et destination
                    </div>
                    <div class="card-body">
                        <canvas id="transactionsByLocationChart" height="200"></canvas>
                    </div>
                </div>
                <!-- Nouveau graphique Montant total transféré par ville d'origine et destination -->
                <div class="card">
                    <div class="card-header">
                        Montant total transféré par ville d'origine et destination
                    </div>
                    <div class="card-body">
                        <canvas id="amountByLocationChart" height="200"></canvas>
                    </div>
                </div>

            </div>

            <!-- Onglet pour les opérateurs et les transactions combinées -->
            <div class="tab-pane" id="combine" role="tabpanel">
                <!-- Insérez ici votre code pour les statistiques combinées d'opérateurs et de transactions -->
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Chart.js -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        $('#annee').on('change', function() {
            // Soumettre le formulaire
            $('#yearSearch').submit();
        });
        // Données pour le graphique Nombre d'opérateurs inscrits par mois
        var usersByMonthData = {!! json_encode($usersByMonth) !!};
        var usersByMonthLabels = usersByMonthData.map(data => data.month);
        var usersByMonthValues = usersByMonthData.map(data => data.total);

        // Données pour le graphique Nombre d'opérateurs par localisation (ville)
        var usersByLocationData = {!! json_encode($usersByLocation) !!};
        var usersByLocationLabels = usersByLocationData.map(data => data.localisation);
        var usersByLocationValues = usersByLocationData.map(data => data.total);

        // Création du graphique Nombre d'opérateurs inscrits par mois
        var usersByMonthChart = new Chart(document.getElementById('usersByMonthChart'), {
            type: 'line',
            data: {
                labels: usersByMonthLabels,
                datasets: [{
                    label: 'Nombre d\'opérateurs inscrits par mois',
                    data: usersByMonthValues,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Création du graphique Nombre d'opérateurs par localisation (ville)
        var usersByLocationChart = new Chart(document.getElementById('usersByLocationChart'), {
            type: 'bar',
            data: {
                labels: usersByLocationLabels,
                datasets: [{
                    label: 'Nombre d\'opérateurs par localisation',
                    data: usersByLocationValues,
                    backgroundColor: 'rgb(54, 162, 235)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Données pour le graphique Nombre de transactions par mois
        var transactionsByMonthData = {!! json_encode($transactionsByMonth) !!};
        var transactionsByMonthLabels = transactionsByMonthData.map(data => data.month);
        var transactionsByMonthValues = transactionsByMonthData.map(data => data.total);
        var ongoingValues = transactionsByMonthData.map(data => data.total_ongoing);
        var successfulValues = transactionsByMonthData.map(data => data.total_successful);
        var cancelledValues = transactionsByMonthData.map(data => data.total_cancelled);

        // Création du graphique Nombre de transactions par mois
        var transactionsByMonthChart = new Chart(document.getElementById('transactionsByMonthChart'), {
            type: 'bar',
            data: {
                labels: transactionsByMonthLabels,
                datasets: [{
                        label: 'En cours',
                        data: ongoingValues,
                        backgroundColor: 'rgb(255, 206, 86)', // Couleur pour les transactions en cours
                        borderWidth: 1
                    },
                    {
                        label: 'Réussies',
                        data: successfulValues,
                        backgroundColor: 'rgb(75, 192, 192)', // Couleur pour les transactions réussies
                        borderWidth: 1
                    },
                    {
                        label: 'Annulées',
                        data: cancelledValues,
                        backgroundColor: 'rgb(255, 99, 132)', // Couleur pour les transactions annulées
                        borderWidth: 1
                    }
                ]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        stacked: true
                    }
                }
            }
        });
        // Nouveau graphique Nombre de transactions par ville d'origine et destination
        var transactionsByLocationData = {!! json_encode($transactionsByLocation) !!};
        var transactionsByLocationLabels = transactionsByLocationData.map(data => data.location);
        var transactionsByLocationOriginValues = transactionsByLocationData.map(data => data.total_origin);
        var transactionsByLocationDestinationValues = transactionsByLocationData.map(data => data.total_destination);

        var transactionsByLocationChart = new Chart(document.getElementById('transactionsByLocationChart'), {
            type: 'bar',
            data: {
                labels: transactionsByLocationLabels,
                datasets: [{
                        label: 'Ville d\'origine',
                        data: transactionsByLocationOriginValues,
                        backgroundColor: 'rgb(54, 162, 235)',
                        borderWidth: 1
                    },
                    {
                        label: 'Ville de destination',
                        data: transactionsByLocationDestinationValues,
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        stacked: true
                    }
                }
            }
        });

        // Nouveau graphique Montant total transféré par ville d'origine et destination
        var amountByLocationData = {!! json_encode($amountByLocation) !!};
        var amountByLocationLabels = amountByLocationData.map(data => data.location);
        var amountByLocationOriginValues = amountByLocationData.map(data => data.total_amount_origin);
        var amountByLocationDestinationValues = amountByLocationData.map(data => data.total_amount_destination);

        var amountByLocationChart = new Chart(document.getElementById('amountByLocationChart'), {
            type: 'bar',
            data: {
                labels: amountByLocationLabels,
                datasets: [{
                        label: 'Ville d\'origine',
                        data: amountByLocationOriginValues,
                        backgroundColor: 'rgb(54, 162, 235)',
                        borderWidth: 1
                    },
                    {
                        label: 'Ville de destination',
                        data: amountByLocationDestinationValues,
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,

                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true
                    }
                }
            }
        });
    </script>
@endsection

