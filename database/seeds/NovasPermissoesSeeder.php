<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class NovasPermissoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $this->command->info('Sincronizando novas permissões...');

        $modules = config('laratrust_seeder.role_structure.super');
        $mapPermission = collect(config('laratrust_seeder.permissions_map'));
    
        $role = \App\Role::where('name', 'super')->first();

        $permissions = [];

        foreach ($modules as $module => $value) {

            foreach (explode(',', $value) as $p => $perm) {

                $permissionValue = $mapPermission->get($perm);

                $permissions[] = \App\Permission::firstOrCreate([
                    'name' => $permissionValue . '-' . $module,
                    'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                    'description' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                ])->id;

                $this->command->info('Criando permissões '.$permissionValue.' para '. $module);
            }
        }

        // Attach all permissions to the role
        $role->permissions()->sync($permissions);

        $this->command->info("Anexando permissões ao usuário super.");

        $this->command->info('Removendo permissções antigas, associadas a qualquer perfil.');
        $oldPermissions = \App\Permission::doesntHave('roles')->get();
        foreach ($oldPermissions as $oldPermission) {
            $this->command->info('Removendo permissão: '.$oldPermission->name);
            $oldPermission->delete();
        }
    }
}