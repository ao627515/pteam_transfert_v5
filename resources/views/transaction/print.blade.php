<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <title>Pteam transfert | Transaction | Impression</title>
</head>

<body>
    <div>
        <h1 class="text-center mb-5">Transaction N°{{ $transaction->id }}</h1>

        <div class="row">
            <div class="col">
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
            <div class="col">
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
        <div class="row">
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
        <div class="d-flex justify-content-between mt-3 mb-5 fw-bold">
            <p>Signature Client</p>
            <p>Signature Opérateur</p>
        </div>
    </div>

    <div>
        <h1 class="text-center mb-5">Transaction N°{{ $transaction->id }}</h1>

        <div class="row">
            <div class="col">
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
            <div class="col">
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
        <div class="row">
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
        <div class="d-flex justify-content-between mt-3 mb-5 fw-bold">
            <p>Signature Client</p>
            <p>Signature Opérateur</p>
        </div>
    </div>
    <script>
        // Fonction pour lancer l'impression
        function printAndRedirect() {
            // Appeler la fonction d'impression
            window.print();

            // Faire la redirection après l'impression (après un court délai pour laisser le temps d'imprimer)
            setTimeout(function() {
                window.history.back(); // Rediriger vers la page précédente
            }, 1000); // Rediriger après 1 seconde (ajustez le délai selon vos besoins)
        }

        // Ajouter un gestionnaire d'événement pour lancer l'impression lorsque la page se charge
        window.onload = printAndRedirect;
    </script>
</body>

</html>
