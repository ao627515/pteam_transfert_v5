<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Termwind\Components\Ol;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\transaction\TransactionFormRequest;
use App\Http\Requests\transaction\TransactionSearchRequest;

class TransactionController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Transaction::class, 'transaction');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $request->validate([
            'search' => 'nullable|string|max:255', // Exemple de validation, ajustez selon vos besoins
            'user_id' => ['nullable', 'string', 'exists:users,id'],
            'user_transactions' => ['nullable', 'string', 'max:2'],
            'etat' => ['nullable', 'integer', Rule::in([0, 1, 2, 3])]
        ]);
        // Récupérer le terme de recherche depuis le formulaire
        $searchTerm = $request->input('search');
        $userId = $request->input('user_id');
        $state = $request->input('etat');

        // Utilisation de la méthode where() de Query Builder pour effectuer la recherche
        $transactions = Transaction::where(function ($query) use ($searchTerm) {
            // Utiliser une sous-requête pour vérifier la correspondance dans toutes les colonnes de la table
            $query->where('nom_expediteur', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('prenom_expediteur', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('telephone_expediteur', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('ville_origine', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('ville_destinataire', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('nom_beneficiaire', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('prenom_beneficiaire', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('telephone_beneficiaire', 'LIKE', '%' . $searchTerm . '%')
                ->Where('montant', '>=', (int) $searchTerm)
                ->Where('etat', '=', (int) $searchTerm)
                ->orWhereDate('date_retrait', 'LIKE', '%' . $searchTerm . '%')
                ->orWhereDate('date_transfert', 'LIKE', '%' . $searchTerm . '%');
        })
            ->orderBy('created_at', 'desc'); // Tri par date de création (décroissant)

        // Filtrer les transactions par utilisateur si un utilisateur est sélectionné
        if ($request->input('user_transactions') && !empty($userId)) {
            $transactions = $transactions->where('user_id', $userId);
        }

        if ($state) {
            $transactions = $transactions->where('etat', $state);
        }


        // Paginer les résultats par 25 éléments par page
        $transactions = $transactions->paginate(25);

        // Ajouter les paramètres de recherche à la requête de pagination
        $transactions->appends($request->only(['search', 'user_id', 'user_transactions', 'etat']));

        // Renvoyer les résultats de la recherche à la vue pour les afficher
        return view('transaction.index', ['transactions' => $transactions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transaction.form', [
            'transaction' => new Transaction(),
            'user' => auth()->user()
        ])->with('success', 'transaction reussi');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionFormRequest $request)
    {

        $transaction = Transaction::create(array_merge(
            $request->validated(),
            [
                'date_transfert' => now(),
                'etat' => 1,
                'code_retrait' => Str::random(6)
            ]
        ));

        return to_route('transaction.show', $transaction)->with('success', 'transaction reussi');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return view('transaction.show', [
            'transaction' => $transaction
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        return view('transaction.form', [
            'transaction' => $transaction
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TransactionFormRequest $request, Transaction $transaction)
    {
        $transaction->update($request->validated());

        return to_route('transaction.show', $transaction)->with('success', 'Transaction Modifier');
    }

    public function cancel(Transaction $transaction)
    {
        if ($transaction->etat != 1) {
            return back()->with('error', 'Annulation de la transaction imposible');
        }

        $transaction->etat = 3;

        $transaction->update();

        return to_route('transaction.show', $transaction)->with('success', 'Transaction Annuler');
    }

    public function withdrawal(Transaction $transaction)
    {
        if ($transaction->etat != 1) {
            return back()->with('error', 'Retrait imposible');
        }


        $transaction->etat = 2;

        $transaction->date_retrait = now();

        $transaction->update();

        return to_route('transaction.show', $transaction)->with('success', 'Retrait effectuer');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return to_route('transaction.index')->with('success', 'Transaction Supprimer');
    }

    public function print (Transaction $transaction) {

        return view('transaction.print', [
            'transaction' => $transaction
        ]);
    }
}
