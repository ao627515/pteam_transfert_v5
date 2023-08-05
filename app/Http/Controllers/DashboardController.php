<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer les années d'existence de l'application depuis la table "transfert"
        $years = DB::table('transactions')
            ->selectRaw('YEAR(date_transfert) as year')
            ->distinct()
            ->pluck('year');

        // Récupérer l'année sélectionnée à partir de la requête (ou utiliser l'année actuelle par défaut)
        $selectedYear = $request->input('annee', Carbon::now()->year);

        // Tableau associatif pour mapper les numéros de mois aux noms de mois
        $months = [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin',
            7 => 'Juillet', 8 => 'Août', 9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
        ];

        // Statistiques pour les utilisateurs
        $totalUsers = DB::table('users')->count();
        $connectedUsers = DB::table('users')->where('est_connecte', true)->count();
        $adminUsers = DB::table('users')->where('role', 'administrateur')->count();
        $operatorUsers = DB::table('users')->where('role', 'opérateur')->count();
        $verifiedUsers = DB::table('users')->whereNotNull('email_verified_at')->count();

        // Statistiques pour le graphique Nombre d'utilisateurs inscrits par mois
        $usersByMonth = DB::table('users')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $selectedYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Mettre à jour les données du graphique avec les noms de mois
        $usersByMonth->transform(function ($item) use ($months) {
            $item->month = $months[$item->month];
            return $item;
        });

        // Statistiques pour le graphique Nombre d'utilisateurs par localisation (ville)
        $usersByLocation = DB::table('users')
            ->select('localisation', DB::raw('COUNT(*) as total'))
            ->groupBy('localisation')
            ->get();

        // Statistiques pour les transactions
        $totalTransactions = DB::table('transactions')->count();
        $totalTransferredAmount = DB::table('transactions')->sum('montant');
        $cancelledTransactions = DB::table('transactions')->where('etat', 3)->count();
        $cancelledAmount = DB::table('transactions')->where('etat', 3)->sum('montant');
        $successfulTransactions = DB::table('transactions')->where('etat', 2)->count();
        $successfulAmount = DB::table('transactions')->where('etat', 2)->sum('montant');
        $averageAmount = DB::table('transactions')->avg('montant');

        // Transactions en cours
        $ongoingTransactions = DB::table('transactions')->where('etat', 1)->get();

        // Montant total des transferts en cours
        $ongoingAmount = DB::table('transactions')->where('etat', 1)->sum('montant');

        // Statistiques pour le graphique Nombre de transactions par mois
        $transactionsByMonth = DB::table('transactions')
            ->selectRaw('MONTH(date_transfert) as month,
                         SUM(CASE WHEN etat = 1 THEN 1 ELSE 0 END) as total_ongoing,
                         SUM(CASE WHEN etat = 2 THEN 1 ELSE 0 END) as total_successful,
                         SUM(CASE WHEN etat = 3 THEN 1 ELSE 0 END) as total_cancelled')
            ->whereYear('date_transfert', $selectedYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Mettre à jour les données du graphique avec les noms de mois
        $transactionsByMonth->transform(function ($item) use ($months) {
            $item->month = $months[$item->month];
            return $item;
        });

        // Transactions par ville d'origine et destination pour l'année sélectionnée
        $transactionsByLocation = $this->getTransactionsByLocation($request);

        // Statistiques pour le graphique Montant total transféré par ville d'origine et destination
        $amountByLocation = $this->getAmountByLocation($request);

        // Passer les données récupérées à la vue
        return view('dashboard.index', [
            'years' => $years,
            'selectedYear' => $selectedYear,
            'months' => $months,
            'totalUsers' => $totalUsers,
            'connectedUsers' => $connectedUsers,
            'adminUsers' => $adminUsers,
            'operatorUsers' => $operatorUsers,
            'verifiedUsers' => $verifiedUsers,
            'usersByMonth' => $usersByMonth,
            'usersByLocation' => $usersByLocation,
            'totalTransactions' => $totalTransactions,
            'totalTransferredAmount' => $totalTransferredAmount,
            'cancelledTransactions' => $cancelledTransactions,
            'cancelledAmount' => $cancelledAmount,
            'successfulTransactions' => $successfulTransactions,
            'successfulAmount' => $successfulAmount,
            'averageAmount' => $averageAmount,
            'ongoingTransactions' => $ongoingTransactions,
            'ongoingAmount' => $ongoingAmount,
            'transactionsByMonth' => $transactionsByMonth,
            'transactionsByLocation' => $transactionsByLocation,
            'amountByLocation' => $amountByLocation,
        ]);
    }

    // ...

    public function getTransactionsByLocation(Request $request)
    {
        $selectedYear = $request->input('annee', date('Y'));

        // Transactions par ville d'origine
        $transactionsByOrigin = Transaction::whereYear('date_transfert', $selectedYear)
            ->groupBy('ville_origine')
            ->select('ville_origine as location', DB::raw('count(*) as total_origin'))
            ->get();

        // Transactions par ville de destination
        $transactionsByDestination = Transaction::whereYear('date_transfert', $selectedYear)
            ->groupBy('ville_destinataire')
            ->select('ville_destinataire as location', DB::raw('count(*) as total_destination'))
            ->get();

        // Créer une nouvelle collection pour combiner les deux tableaux de données
        $transactionsByLocation = collect([]);

        // Fusionner les éléments avec la même clé "location" dans une nouvelle collection
        foreach ($transactionsByOrigin as $originItem) {
            $destinationItem = $transactionsByDestination->where('location', $originItem->location)->first();

            if ($destinationItem) {
                $transactionsByLocation->push([
                    'location' => $originItem->location,
                    'total_origin' => $originItem->total_origin,
                    'total_destination' => $destinationItem->total_destination,
                ]);
            } else {
                $transactionsByLocation->push([
                    'location' => $originItem->location,
                    'total_origin' => $originItem->total_origin,
                    'total_destination' => 0,
                ]);
            }
        }

        // Ajouter les éléments restants de la collection de destination qui n'existent pas dans la collection d'origine
        foreach ($transactionsByDestination as $destinationItem) {
            $originItem = $transactionsByOrigin->where('location', $destinationItem->location)->first();

            if (!$originItem) {
                $transactionsByLocation->push([
                    'location' => $destinationItem->location,
                    'total_origin' => 0,
                    'total_destination' => $destinationItem->total_destination,
                ]);
            }
        }

        return $transactionsByLocation->toArray();
    }

    // ...

    public function getAmountByLocation(Request $request)
    {
        $selectedYear = $request->input('annee', date('Y'));

        // Montant total transféré par ville d'origine
        $amountByOrigin = Transaction::whereYear('date_transfert', $selectedYear)
            ->groupBy('ville_origine')
            ->select('ville_origine as location', DB::raw('SUM(montant) as total_amount_origin'))
            ->get();

        // Montant total transféré par ville de destination
        $amountByDestination = Transaction::whereYear('date_transfert', $selectedYear)
            ->groupBy('ville_destinataire')
            ->select('ville_destinataire as location', DB::raw('SUM(montant) as total_amount_destination'))
            ->get();

        // Créer une nouvelle collection pour combiner les deux tableaux de données
        $amountByLocation = collect([]);

        // Fusionner les éléments avec la même clé "location" dans une nouvelle collection
        foreach ($amountByOrigin as $originItem) {
            $destinationItem = $amountByDestination->where('location', $originItem->location)->first();

            if ($destinationItem) {
                $amountByLocation->push([
                    'location' => $originItem->location,
                    'total_amount_origin' => $originItem->total_amount_origin,
                    'total_amount_destination' => $destinationItem->total_amount_destination,
                ]);
            } else {
                $amountByLocation->push([
                    'location' => $originItem->location,
                    'total_amount_origin' => $originItem->total_amount_origin,
                    'total_amount_destination' => 0,
                ]);
            }
        }

        // Ajouter les éléments restants de la collection de destination qui n'existent pas dans la collection d'origine
        foreach ($amountByDestination as $destinationItem) {
            $originItem = $amountByOrigin->where('location', $destinationItem->location)->first();

            if (!$originItem) {
                $amountByLocation->push([
                    'location' => $destinationItem->location,
                    'total_amount_origin' => 0,
                    'total_amount_destination' => $destinationItem->total_amount_destination,
                ]);
            }
        }

        return $amountByLocation->toArray();
    }
}
