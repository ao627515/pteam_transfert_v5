<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TransactionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Transaction $transaction): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Transaction $transaction): Response
    {

        if (
            $user->role === 'administrateur'
            or
            $user->id === ($transaction->user->id ?? null)
        ) {

            return Response::allow();
        } else {
            return Response::deny("Vous n'ête pas authorisé a Modifier cette transaction");
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Transaction $transaction): bool
    {
        return $user->role === 'administrateur';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Transaction $transaction): bool
    {
        return $user->role === 'administrateur';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Transaction $transaction): bool
    {
        return $user->role === 'administrateur';
    }

    public function cancel(User $user, Transaction $transaction): bool
    {
        return $user->role === 'administrateur' or $user->id === $transaction->user->id;
    }

    public function withdrawal(User $user, Transaction $transaction): bool
    {
        return  $user->role === 'administrateur'
                                or
                $user->locaisation === $transaction->ville_destinataire;
    }
}
