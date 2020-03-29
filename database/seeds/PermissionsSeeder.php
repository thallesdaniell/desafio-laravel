<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

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
            'cliente-listar',
            'cliente-criar',
            'cliente-editar',
            'cliente-deletar',
            'usuario-listar',
            'usuario-criar',
            'usuario-editar',
            'usuario-deletar',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission]
            );
        }
    }
}
