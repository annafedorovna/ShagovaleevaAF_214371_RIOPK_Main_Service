<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;

class UsersController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! auth()->user() && auth()->user()->isAllow('users_manage')) {
            return abort(500);
        }

        $users = collect(User::fetchAll(1)['data'])->map(function ($user) {
            return (object)$user;
        });

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! auth()->user() && auth()->user()->isAllow('users_manage')) {
            return abort(500);
        }
        $roles = Role::get()->pluck('name', 'name');

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersRequest $request)
    {
        if (! auth()->user() && auth()->user()->isAllow('users_manage')) {
            return abort(500);
        }
        $user = (object)User::storeItem(
            $request->get('name'),
            $request->get('email'),
            $request->get('password')
        );
        $roles = $request->input('roles') ? $request->input('roles') : [];
        $roles = Role::whereIn('name', $roles)->get()->pluck('id')->toArray();
//        $user->assignRole($roles);
        User::doSyncRoles($roles, $user->id);


        return redirect()->route('admin.users.index');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! auth()->user() && auth()->user()->isAllow('users_manage')) {
            return abort(500);
        }
        $roles = Role::get()->pluck('name', 'name');

        $user = (object)User::fetchItem($id);

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsersRequest $request, $id)
    {
        if (! auth()->user() && auth()->user()->isAllow('users_manage')) {
            return abort(500);
        }
        $user = User::updateItem(
            $id,
            $request->get('name'),
            $request->get('email'),
            $request->get('password')
        );

        $roles = $request->input('roles') ? $request->input('roles') : [];
        $roles = Role::whereIn('name', $roles)->get()->pluck('id')->toArray();
//        $user->syncRoles($roles);
        User::doSyncRoles($roles, $id);

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! auth()->user() && auth()->user()->isAllow('users_manage')) {
            return abort(500);
        }

        User::deleteItem($id);

        return redirect()->route('admin.users.index');
    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! auth()->user() && auth()->user()->isAllow('users_manage')) {
            return abort(500);
        }
        if ($request->input('ids')) {
            foreach ($request->input('ids') as $id) {
                User::deleteItem($id);
            }
        }
    }

}
