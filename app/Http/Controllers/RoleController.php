<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
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
        $roles = Auth::user()->roles
            ->whereNotIn('name', [
                config('desafio.role-default'), config('desafio.role-guest')
            ]);
        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('role.create', ['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                'name'        => 'required|unique:roles',
                'permissions' => 'required',
            ]
        );

        $name       = $request['name'];
        $role       = new Role();
        $role->name = $name;

        $permissions = $request['permissions'];

        $role->save();
        Auth::user()->assignRole($name);

        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail();

            $role = Role::where('name', '=', $name)->first();
            $role->givePermissionTo($p);
        }

        return redirect()->route('role.index')
            ->with('message', 'Perfil ' . $role->name . ' adicionado!');
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
        $permissions      = Permission::all();
        $role             = Auth::user()
            ->roles()
            ->whereNotIn('name', [
                config('desafio.role-default'), config('desafio.role-guest')
            ])
            ->findOrFail($id);
        $role_permissions = $role->permissions->pluck('name');

        return view('role.edit', compact('role', 'permissions', 'role_permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $this->validate($request, [
            'name'        => 'required|unique:roles,name,' . $id,
            'permissions' => 'required',
        ]);

        $input       = $request->except(['permissions']);
        $permissions = $request['permissions'];


        $role->fill($input)->save();

        $p_all = Permission::all();

        foreach ($p_all as $p) {
            $role->revokePermissionTo($p);
        }

        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail();
            $role->givePermissionTo($p);
        }

        return redirect()->route('role.index')
            ->with('message', 'Perfil ' . $role->name . ' atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        $role->delete();
        return redirect()->route('role.index')
            ->with('message', 'Perfil deletado com sucesso.');
    }
}
