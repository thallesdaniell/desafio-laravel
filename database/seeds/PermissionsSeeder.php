<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            "Visualizar Histórico",
            "Visualizar Histórico Todos",
            "Visualizar Telefones",
            "Editar Telefone",
            "Excluir Telefone"
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission]
            );
        }
    }
}
