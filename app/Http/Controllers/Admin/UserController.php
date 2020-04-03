<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Guest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:' . config('desafio.role-admin'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.user.create', compact('roles'));
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
        $user->save();

        return redirect()->route('admin-user.index')
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

        return view('admin.user.edit', compact('user', 'roles', 'roles_user'));
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

        return redirect()->route('admin-user.edit', $user->id)
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
            return redirect()->route('admin-user.index')
                ->with('message_error', 'Você não pode se deletar.');
        }

        if(!$user->from_guest){
            $user->guest()->delete();
        }else{
            $user->from_guest()->delete();
        }

        $user->roles()->detach();
        $user->delete();
        return redirect()->route('admin-user.index')
            ->with('message', 'Usuário deletado com sucesso.');
    }
}
