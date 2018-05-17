<?php

namespace App\Http\Controllers;

use App\Role;
use App\Permission;
use App\RolePermission;
use App\PermissionRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class RolesController extends Controller
{
    public $fields = [
        'id' => 'ID',
        'name' => 'Identificação',
        'display_name' => 'Perfil',
        'description' => 'Descrição'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->SearchField) {
            $roles = DB::table('roles')
                        ->where('name', 'like', '%'.$request->searchField.'%')
                        ->orWhere('display_name', 'like', '%'.$request->searchField.'%')
                        ->orWhere('description', 'like', '%'.$request->searchField.'%')
                        ->paginate();
        } else {
            $roles = Role::paginate();
        }

        return View('role.index', [
            'roles' => $roles,
            'fields' => $this->fields
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::orderBy('name', 'asc')->get();

        return View('role.create', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $this->validate($request, [
            'name' => 'required|string|min:5|max:100|unique:roles',
            'display_name' => 'required|string|max:100|unique:roles'
        ]);

        try {
            DB::beginTransaction();

            $role_id = DB::table('roles')->insertGetId([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'description' => $request->description
            ]);

            foreach ($request->permissions as $permission) {
                DB::table('permission_role')->insert([
                    'permission_id' => $permission,
                    'role_id' => $role_id
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();

            Session::flash('error', 'Oops, have one error...'.$e->getMessage());
            return redirect()->back(Input::all());
        }

        DB::commit();
        
        Session::flash('success', 'Role '.$request->display_name.' successfull created');
        return redirect()->action('RolesController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('id', 'asc')->get();
        $role = Role::find($role->id);

        foreach ($role->permissions as $permission) {
            $assigned_permissions[] = $permission->id;
        }

        return View('role.edit', [
            'role' => $role,
            'permissions' => $permissions,
            'assigned_permissions' => $assigned_permissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'name' => 'required|string|min:5|max:100|unique:roles,id,'.$role->id,
            'display_name' => 'required|string|max:100|unique:roles,id,'.$role->id
        ]);

        DB::beginTransaction();
        try {
            DB::table('roles')
                    ->where('id', $role->id)
                    ->update([
                        'display_name' => $request->display_name,
                        'description' => $request->description
                    ]);
            
            $this->updatePermissions($request, $role);
                    
            DB::commit();

            Session::flash('success', 'Role '.$request->display_name.' successfull updated');
            return redirect()->action('RolesController@index');
            
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', 'Oops, have one error...'.$e->getMessage());
            return redirect()->back(Input::all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        try {
            $role = Role::find($role->id);
            if ($role->delete()) {
                Session::flash('success', 'Role '.$role->display_name.' successfull removed.');
                
                return redirect()->action('RolesController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Oops, have one error...'.$e->getMessage());
            return redirect()->action('RolesController@index');
        }
    }

    public function updatePermissions(Request $request, Role $role) {
        $this->removeOldPermissions($request, $role);
        $this->addNewPermissions($request, $role);
    }

    public function removeOldPermissions(Request $request, Role $role) {
        DB::table('permission_role')->where('role_id', $role->id)
                                    ->whereNotIn('permission_id', $request->permissions)
                                    ->delete();
    }

    public function addNewPermissions(Request $request, Role $role) {
        $actualPermissions = DB::table('permission_role')->select('permission_id')->where('role_id', $role->id)->get();
        
        foreach ($request->permissions as $newPermission) {
            $dbPermission = DB::table('permission_role')->where('role_id', $role->id)->where('permission_id', $newPermission)->first();
            if ($dbPermission === null) {
                try {
                    DB::table('permission_role')->insert([
                        'permission_id' => $newPermission,
                        'role_id' => $role->id
                    ]);
                } catch (\Exception $e) {
                    dd($e);
                }
            }
        }
    }
}
