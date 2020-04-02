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
        $this->middleware('role:' . config('desafio.role-default'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guests = Auth::user()->guest;
        return view('user.index', compact('guests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        $roles = Auth::user()
            ->roles()
            ->whereNotIn('name', [
                config('desafio.role-default'), config('desafio.role-guest')
            ])
            ->get();

        if ($roles->isEmpty())
            return redirect()
                ->route('role.create')
                ->with('message_warning', 'Para cadastrar um usuário precisa ter pelo menos um perfil cadastrado!');

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


        $roles = $request->get('roles');
        if (isset($roles)) {
            foreach ($roles as $role) {
                $role_r = Role::where('name', '=', $role)->firstOrFail();
                $user->assignRole($role_r);
            }
        }
        $user->assignRole(config('desafio.role-guest'));
        $user->save();

        Auth::user()->guest()->create(['guest_id' => $user->id]);

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
        $roles      = Auth::user()
            ->roles()
            ->whereNotIn('name', [
                config('desafio.role-default'), config('desafio.role-guest')
            ])
            ->get();
        $user       = User::findOrFail($id);
        $roles_user = $user->roles->pluck('name');

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

        $user->save();

        $roles[] = $request['roles'];

        if (isset($roles)) {
            $user->syncRoles($roles);
        } else {
            $user->roles()->detach();
        }

        return redirect()->route('user.index')
            ->with('message', 'Usuario editado com sucesso.');
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
