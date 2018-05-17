<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\RoleUser;
use Illuminate\Http\Request;
use App\Rules\ValidRoleUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class RoleUsersController extends Controller
{
    public $fields = [
        'id' => 'ID',
        'display_name' => 'Perfil',
        'name' => 'Usuário'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->searchField) {
            $roleUsers = DB::table('role_user')
                            ->select('role_user.*', 'roles.display_name', 'users.name')
                            ->join('users', 'users.id', 'role_user.user_id')
                            ->join('roles', 'roles.id', 'role_user.role_id')
                            ->where('roles.display_name', 'like', '%'.$request->searchField.'%')
                            ->orWhere('users.name', 'like', '%'.$request->searchField.'%')
                            ->orWhere('users.email', 'like', '%'.$request->searchField.'%')
                            ->orderBy('role_user.role_id', 'asc')
                            ->paginate();
        } else {
            $roleUsers = DB::table('role_user')
                            ->select('role_user.*', 'roles.display_name', 'users.name')
                            ->join('users', 'users.id', 'role_user.user_id')
                            ->join('roles', 'roles.id', 'role_user.role_id')
                            ->orderBy('role_user.role_id', 'asc')
                            ->paginate();
        }

        return View('role_user.index', [
                'roleUsers' => $roleUsers,
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
        if (Auth::user()->canCadastrarRoleUser()) {
            $roles = Role::all();
            $users = User::all();

            return View('role_user.create', [
                'roles' => $roles,
                'users' => $users
            ]);
        } else {
            Session::flash('error', env('ACCESS_DENIED_MSG'));
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::find($request->role_id);
        $user = User::find($request->user_id);

        $this->validate($request, [
            'role_id' => 'required|numeric',
            'user_id' => ['required', 'numeric', new ValidRoleUser($role, $user)],
        ]);

        try {
            $roleUser = new RoleUser($request->all());
            $roleUser->user_type = 'App\User';
            
            if ($roleUser->save()) {
                Session::flash('success', 'Role vs User association successfull created');
                return redirect()->action('RoleUsersController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Oops, have one error...'.$e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RoleUser  $roleUser
     * @return \Illuminate\Http\Response
     */
    public function show(RoleUser $roleUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RoleUser  $roleUser
     * @return \Illuminate\Http\Response
     */
     public function edit(RoleUser $roleUser)
    {        
        //dd($roleUser);
        $users = User::all();
        $roles = Role::all();
        
        $roleUser = RoleUser::find($roleUser->id);

        return View('role_user.edit', [
            'users' => $users,
            'roles' => $roles,
            'roleUser' => $roleUser
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RoleUser  $roleUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoleUser $roleUser)
    {
        $role = Role::find($request->role_id);
        $user = User::find($request->user_id);

        $this->validate($request, [
            'role_id' => 'numeric|required',
            'user_id' => ['required', 'numeric', new ValidRoleUser($role, $user)],
        ]);

        try {
            $roleUser = RoleUser::find($roleUser->id);
            $roleUser->user_id = $request->user_id;
            $roleUser->role_id = $request->role_id;

            if ($roleUser->save()) {
                Session::flash('success', 'Role vs User association successfull updated');
                return redirect()->action('RoleUsersController@index');
            } else {
                throw new \Exception('Role User cannot be saved!');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Oops, have one error...'.$e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RoleUser  $roleUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoleUser $roleUser)
    {
        try {
            $roleUser = RoleUser::find($roleUser->id);
            if ($roleUser->delete()) {
                Session::flash('success', 'Role vs User '.$roleUser->user->name.' - '.$roleUser->role->display_name.' successfull removed.');
                
                return redirect()->action('RoleUsersController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Oops, have one error...'.$e->getMessage());
            return redirect()->action('RoleUsersController@index');
        }
    }
}
