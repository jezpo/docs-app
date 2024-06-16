<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\Datatables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view user', ['only' => ['index']]);
        $this->middleware('permission:create user', ['only' => ['create', 'store']]);
        $this->middleware('permission:update user', ['only' => ['update', 'edit']]);
        $this->middleware('permission:delete user', ['only' => ['destroy']]);
        $this->middleware('permission:toggle user status', ['only' => ['toggleStatus']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::all()->map(function ($user) {
                $roles = $user->roles->pluck('name')->implode(', ');
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'last_name' => $user->last_name,
                    'ci' => $user->ci,
                    'email' => $user->email,
                    'roles' => $roles,
                    'status' => $user->status,
                    'action' => '<a href="' . url('users/' . $user->id . '/edit') . '" class="btn btn-success"><i class="far fa-lg fa-fw m-r-10 fa-edit"></i> Editar</a>'
                        . (auth()->user()->can('delete user') ? '<a href="' . url('users/' . $user->id . '/delete') . '" class="btn btn-danger mx-2"><i class="fas fa-lg fa-fw m-r-10 fa-trash-alt"></i> Eliminar</a>' : '')
                        . (auth()->user()->can('toggle user status') ? '<form action="' . route('users.toggleStatus', $user->id) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            <button type="submit" class="btn ' . ($user->status ? 'btn-warning' : 'btn-primary') . ' mx-2">
                            <i class="fas fa-lg fa-fw m-r-10 ' . ($user->status ? 'fa-user-slash' : 'fa-user-check') . '"></i>' . ($user->status ? ' Dar de Baja' : ' Dar de Alta') . '
                            </button>
                           </form>' : ''),
                ];
            });
            return response()->json(['data' => $users]);
        }

        return view('role-permission.user.index');
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('role-permission.user.create', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'ci' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:20',
            'roles' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'ci' => $request->ci,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => true,
        ]);

        $user->syncRoles($request->roles);

        return redirect('/users')->with('status', 'Usuario creado exitosamente con roles');
    }

    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();
        return view('role-permission.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'ci' => ['required', 'string', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|max:20',
            'roles' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'last_name' => $request->last_name,
            'ci' => $request->ci,
            'email' => $request->email,
        ];

        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->syncRoles($request->roles);

        return redirect('/users')->with('status', 'Usuario actualizado exitosamente con roles');
    }

    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect('/users')->with('status', 'Usuario eliminado exitosamente');
    }

    public function toggleStatus($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['status' => !$user->status]);

        return redirect('/users')->with('status', $user->status ? 'Usuario dado de alta exitosamente' : 'Usuario dado de baja exitosamente');
    }
}
