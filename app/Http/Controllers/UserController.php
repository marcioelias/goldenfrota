<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public $fields = array(
        'id' => 'ID',
        'name' => 'Nome',
        'username' => 'Usuário',
        'email' => 'E-mail',
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
     {
         $this->middleware('auth');
     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (isset($request->searchField)) {
            $users = DB::table('users')
                        ->where('name', 'like', '%'.$request->searchField.'%')
                        ->orWhere('username', 'like', '%'.$request->searchField.'%')
                        ->orWhere('email', 'like', '%'.$request->searchField.'%')
                        ->paginate();
        } else {
            $users = User::paginate();
        }

        return View('user.index')->withUsers($users)->withFields($this->fields);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('user.create');
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
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:4|max:12|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);

            if ($user->save()) {
                Session::flash('success', 'Usuário '.$user->name.' cadastrado com sucesso.');
                return redirect()->action('UserController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return View('user.create', [
                'users' => User::find($user->id)
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user = User::find($user->id);

        return View('user.edit')->withUser($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|min:4|max:12|unique:users,id,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,id,'.$user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        try {
            //dd($request->password);
            $user = User::find($user->id);
            $user->name = $request->name;
            if (!is_null($request->password)) {
                //dd('password setado -> ');
                $user->password = bcrypt($request->password);
            }
            if ($user->email != $request->email) {
                $user->email = $request->email;
            }
            $user->ativo = $request->ativo;

            // dd($user);            

            if ($user->save()) {
                Session::flash('success', 'Usuário '.$user->name.' alterado com sucesso.');
                return redirect()->action('UserController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return View('user.create', [
                'users' => User::find($user->id)
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user = User::find($user->id);
            if ($user->delete()) {
                Session::flash('success', 'Usuário '.$user->name.' removido com sucesso.');
                
                return redirect()->action('UserController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Registro não pode ser excluído. '.$e->getMessage());
            return redirect()->action('UserController@index');
        }
    }
}
