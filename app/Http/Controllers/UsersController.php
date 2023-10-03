<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function index()
    {
        if (auth()->user()->can('VerUsuarios')) {
            $users = User::all();
            return view('users.index', compact('users'));
        } else {
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para ver usuarios.');
        }
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request)
    {
        // Crear el usuario
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        // Verificar si el rol está disponible en la solicitud y asignarlo al usuario
        if ($request->has('role')) {
            $user->assignRole($request->input('role'));
        } else {
            // Asignar un rol predeterminado si no se especifica uno
            $user->assignRole('Usuario');
        }

        // Asignar permisos según el rol (por ejemplo, para administradores)
        if ($user->hasRole('Administrador')) {
            $user->givePermissionTo('VerUsuarios');
            // Otros permisos de administrador aquí
        }

        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        $roles = $user->getRoleNames();
        return view('users.show', compact('user', 'roles'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}
