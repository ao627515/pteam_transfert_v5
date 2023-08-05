<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear = $request->input('year', now()->year);

        // Récupérer les données de transactions en cours pour chaque mois de l'année sélectionnée
        $transactionsInCourse = Transaction::whereYear('date_transfert', $selectedYear)
            ->where('etat', 1)
            ->groupBy(DB::raw('MONTH(date_transfert)'))
            ->orderBy(DB::raw('MONTH(date_transfert)'))
            ->get([
                DB::raw('COUNT(*) as total'),
                DB::raw('MONTH(date_transfert) as month')
            ])
            ->pluck('total', 'month');

        // Récupérer les données de transactions retirées pour chaque mois de l'année sélectionnée
        $transactionsWithdrawn = Transaction::whereYear('date_transfert', $selectedYear)
            ->where('etat', 2)
            ->groupBy(DB::raw('MONTH(date_transfert)'))
            ->orderBy(DB::raw('MONTH(date_transfert)'))
            ->get([
                DB::raw('COUNT(*) as total'),
                DB::raw('MONTH(date_transfert) as month')
            ])
            ->pluck('total', 'month');

        // Récupérer les données de transactions annulées pour chaque mois de l'année sélectionnée
        $transactionsCancelled = Transaction::whereYear('date_transfert', $selectedYear)
            ->where('etat', 3)
            ->groupBy(DB::raw('MONTH(date_transfert)'))
            ->orderBy(DB::raw('MONTH(date_transfert)'))
            ->get([
                DB::raw('COUNT(*) as total'),
                DB::raw('MONTH(date_transfert) as month')
            ])
            ->pluck('total', 'month');

        // Créer un tableau contenant les mois de l'année sous forme de clés
        $months = array_combine(range(1, 12), [
            'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
            'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
        ]);

        // Nombre total de transactions effectuées
        $totalTransactions = Transaction::whereYear('date_transfert', $selectedYear)->count();

        // Montant total transféré dans toutes les transactions
        $totalAmountTransferred = Transaction::whereYear('date_transfert', $selectedYear)->sum('montant');

        // Montant moyen transféré par transaction
        $averageAmount = Transaction::whereYear('date_transfert', $selectedYear)->avg('montant');

        // Récupérer les données de transactions pour chaque ville d'origine
        $transactionsByOriginCity = Transaction::whereYear('date_transfert', $selectedYear)
            ->groupBy('ville_origine')
            ->orderBy('ville_origine')
            ->get([
                DB::raw('COUNT(*) as total'),
                'ville_origine'
            ])
            ->pluck('total', 'ville_origine');

        // Récupérer les données de transactions pour chaque ville de destination
        $transactionsByDestinationCity = Transaction::whereYear('date_transfert', $selectedYear)
            ->groupBy('vile_destinataire')
            ->orderBy('vile_destinataire')
            ->get([
                DB::raw('COUNT(*) as total'),
                'vile_destinataire'
            ])
            ->pluck('total', 'vile_destinataire');

        // Montant total transféré pour chaque ville d'origine
        $amountByOriginCity = Transaction::whereYear('date_transfert', $selectedYear)
            ->groupBy('ville_origine')
            ->orderBy('ville_origine')
            ->get([
                DB::raw('SUM(montant) as total_amount'),
                'ville_origine'
            ])
            ->pluck('total_amount', 'ville_origine');

        // Montant total transféré pour chaque ville de destination
        $amountByDestinationCity = Transaction::whereYear('date_transfert', $selectedYear)
            ->groupBy('vile_destinataire')
            ->orderBy('vile_destinataire')
            ->get([
                DB::raw('SUM(montant) as total_amount'),
                'vile_destinataire'
            ])
            ->pluck('total_amount', 'vile_destinataire');

        // Nombre total d'utilisateurs enregistrés dans le système
        $totalUsers = User::count();

        // Nombre d'utilisateurs avec le rôle "administrateur"
        $adminUsers = User::where('role', 'administrateur')->count();

        // Nombre d'utilisateurs avec le rôle "utilisateur" (non administrateur)
        $regularUsers = $totalUsers - $adminUsers;

        // Nombre d'utilisateurs connectés actuellement (est_connecte = true)
        $connectedUsers = User::where('est_connecte', true)->count();

        // Nombre d'utilisateurs pour chaque localisation (groupé par localisation)
        $usersByLocation = User::groupBy('localisation')
            ->orderBy('localisation')
            ->get([
                DB::raw('COUNT(*) as total_users'),
                'localisation'
            ])
            ->pluck('total_users', 'localisation');

        // Nombre d'utilisateurs enregistrés par mois (groupé par mois)
        $usersByMonth = User::groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get([
                DB::raw('COUNT(*) as total_users'),
                DB::raw('MONTH(created_at) as month')
            ])
            ->pluck('total_users', 'month')
            ->map(function ($total, $month) use ($months) {
                $monthName = substr($months[$month], 0, 4); // Récupère les 3 premières lettres du mois
                return [$monthName => $total];
            })
            ->reduce(function ($carry, $item) {
                return array_merge($carry, $item);
            }, []);

        // Récupérer les données de transactions pour chaque utilisateur (groupé par utilisateur)
        $transactionsByUser = Transaction::groupBy('user_id')
            ->orderBy('user_id')
            ->get([
                DB::raw('COUNT(*) as total_transactions'),
                'user_id'
            ])
            ->pluck('total_transactions', 'user_id');

        // Passer les données à la vue
        return view('dashboard.index', compact(
            'transactionsInCourse',
            'transactionsWithdrawn',
            'transactionsCancelled',
            'months',
            'selectedYear',
            'totalTransactions',
            'totalAmountTransferred',
            'averageAmount',
            'transactionsByOriginCity',
            'transactionsByDestinationCity',
            'amountByDestinationCity',
            'amountByOriginCity',
            'totalUsers',
            'adminUsers',
            'regularUsers',
            'connectedUsers',
            'usersByLocation',
            'usersByMonth',
            'transactionsByUser'
        ));
    }
}
