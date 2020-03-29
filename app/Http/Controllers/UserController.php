<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:usuario-listar', ['only' => ['index', 'show']]);
        $this->middleware('permission:usuario-criar', ['only' => ['create', 'store']]);
        $this->middleware('permission:usuario-editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:usuario-deletar', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        $this->authorize('permission', auth()->user());

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();

        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $user           = new User();
        $user->name     = $request->get('name');
        $user->email    = $request->get('email');
        $user->password = bcrypt($request->get('password'));

        $this->authorize('permission', $user);

        $roles = $request->get('roles');
        if (isset($roles)) {
            foreach ($roles as $role) {
                $role_r = Role::where('id', '=', $role)->firstOrFail();
                $user->assignRole($role_r);
            }
        }
        $user->save();

        return redirect()->route('user.index')
            ->with('message', 'Usuário adicionado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles      = Role::all();
        $user       = User::findOrFail($id);
        $roles_user = $user->roles->pluck('name');

        $this->authorize('permission', $user);

        return view('user.edit', compact('user', 'roles', 'roles_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user        = User::findOrFail($id);
        $user->name  = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $this->authorize('permission', $user);

        $user->save();

        if (auth()->user()->is_admin) {
            $roles[] = $request['roles'];

            if (isset($roles)) {
                $user->syncRoles($roles);
            } else {
                $user->roles()->detach();
            }
            return redirect()->route('user.index')
                ->with('message', 'Usuario editado com sucesso.');
        }

        return redirect()->route('user.edit', $user->id)
            ->with('message', 'Usuário editado com sucesso.');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $this->authorize('permission', $user);

        if ($user->id == Auth::id()) {
            return redirect()->route('user.index')
                ->with('message_error', 'Você não pode se deletar.');
        }

        $user->roles()->detach();
        $user->delete();
        return redirect()->route('user.index')
            ->with('message', 'Usuário deletado com sucesso.');
    }
}
