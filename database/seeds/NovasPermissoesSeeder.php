<?php

use Illuminate\Database\Seeder;

class NovasPermissoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Truncating User, Role and Permission tables');
        //$this->truncateLaratrustTables();

        $config = config('laratrust_seeder.role_structure');
        $userPermission = config('laratrust_seeder.permission_structure');
        $mapPermission = collect(config('laratrust_seeder.permissions_map'));

        foreach ($config as $key => $modules) {
            $permissions = [];

            // Reading role permission modules
            foreach ($modules as $module => $value) {

                foreach (explode(',', $value) as $p => $perm) {

                    $permissionValue = $mapPermission->get($perm);

                    $permissions[] = \App\Permission::firstOrCreate([
                        'name' => $permissionValue . '-' . str_replace('_', '-', $module),
                        'display_name' => ucfirst($permissionValue) . ' ' . ucfirst(str_replace('_', ' ', $module)),
                        'description' => ucfirst($permissionValue) . ' ' . ucfirst(str_replace('_', ' ', $module)),
                    ])->id;

                    $this->command->info('Creating Permission to '.$permissionValue.' for '. str_replace('_', ' ', $module));
                }
            }

            // Attach all permissions to the role Super
            //$role = \App\Role::where('name', 'super')->first();
            //$role->permissions()->sync($permissions);
        }
    }

    /**
     * Truncates all the laratrust tables and the users table
     *
     * @return    void
     */
    public function truncateLaratrustTables()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permission_role')->truncate();
        DB::table('permission_user')->truncate();
        DB::table('role_user')->truncate();
        \App\User::truncate();
        \App\Role::truncate();
        \App\Permission::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
