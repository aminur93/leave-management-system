<?php

namespace App\Http\Services\Admin;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function index(Request $request)
    {
        $users = User::with('roles', 'roles.permissions');

        if ($request->has('sortBy') && $request->has('sortDesc')) {

            $sortBy = $request->query('sortBy');

            $sortDesc = $request->query('sortDesc') === 'true' ? 'desc' : 'asc';

            $users = $users->orderBy($sortBy, $sortDesc);

        } else {

            $users = $users->orderBy('name', 'desc');
        }

        $searchValue = $request->input('search');
        $itemsPerPage = $request->input('itemsPerPage');
        $defaultItemsPerPage = 10;

        if ($searchValue)
        {
            $users->where(function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('email', 'like', '%' . $searchValue . '%');
            });

            $itemsPerPage = 10;

            if($request->has('itemsPerPage')) {
                $itemsPerPage = $request->get('itemsPerPage');

                return $users->paginate($itemsPerPage, ['*'], $request->get('page'));
            }
        }

        if ($itemsPerPage)
        {
            return $users->paginate($itemsPerPage);
        }

        return $users->paginate($defaultItemsPerPage);
    }

    public function getAllUser()
    {
        $users = User::with('roles', 'permissions')->latest()->get();

        return $users;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            //storing users
            $user = new  User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);

            $user->syncRoles($request->role);

            $user->save();

            DB::commit();

            return $user;

        }catch (\Throwable $throwable){
            DB::rollBack();

            throw $throwable;
        }
    }

    public function edit($id)
    {
        $user = User::with('roles', 'roles.permissions')->where('id', $id)->first();

        if ($id != $user->id)
        {
            throw new \Exception("Model not found");
        }

        return $user;
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            // update user

            $user = User::findOrFail($id);

            $user->name = $request->name;
            $user->email = $request->email;

            // Update password if provided
            if ($request->has('password')) {
                $user->password = bcrypt($request->password);
            }

            if ($request->has('role'))
            {
                $user->syncRoles($request->role);
            }


            $user->save();

            DB::commit();

            return $user;

        }catch (\Throwable $throwable){

            DB::rollBack();

            throw $throwable;
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->roles()->detach();

        $user->delete();

        return $user;
    }
}
