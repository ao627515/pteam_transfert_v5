<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\User\UserFormRequest;


class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255', // Exemple de validation, ajustez selon vos besoins
            'role' => ['nullable', 'array', 'max:15'],
            'est_connecte' => ['nullable', 'array']
        ]);

        $searchTerm = $request->input('search');
        $roles = $request->input('role');
        $estConnecte = $request->input('est_connecte');

        $users = User::where(function ($query) use ($searchTerm, $roles, $estConnecte) {
            if ($searchTerm) {
                $query->where('nom', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('prenom', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('telephone', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('role', 'LIKE', '%' . $searchTerm . '%');
            }

            if ($roles) {
                $query->whereIn('role', $roles);
            }

            if ($estConnecte) {
                $query->whereIn('est_connecte', $estConnecte);
            }
        })
        ->orderBy('created_at', 'desc')
        ->paginate(25);

        $users->appends($request->only(['search', 'role', 'est_connecte']));

        return view('operateur.index', [
            'users' => $users
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('operateur.form', [
            'user' => new User()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserFormRequest $request)
    {

        $user = User::create(array_merge($request->validated(), [
            'password' => '12345678'
        ]));
        // event(new Registered($user));
        return to_route('user.index')->with('success', 'Opérateur enregistrer');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

        return view('operateur.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('operateur.form', [
          'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserFormRequest $request, User $user)
    {

        $user->update($request->validated());

        return to_route('user.index')->with('success', 'Modification reussi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return to_route('user.index')->with('success', 'Operateur supprimer');
    }
}
