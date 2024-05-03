<?php

namespace App\Http\Services\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function index(Request $request)
    {
        $roles = Role::with('permissions');

        if ($request->has('sortBy') && $request->has('sortDesc')) {

            $sortBy = $request->query('sortBy');

            $sortDesc = $request->query('sortDesc') === 'true' ? 'desc' : 'asc';

            $roles = $roles->orderBy($sortBy, $sortDesc);

        } else {

            $roles = $roles->orderBy('name', 'desc');
        }

        $searchValue = $request->input('search');
        $itemsPerPage = $request->input('itemsPerPage');
        $defaultItemsPerPage = 10;

        if ($searchValue)
        {
            $roles->where(function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%');
            });

            $itemsPerPage = 10;

            if($request->has('itemsPerPage')) {
                $itemsPerPage = $request->get('itemsPerPage');

                return $roles->paginate($itemsPerPage, ['*'], $request->get('page'));
            }
        }

        if ($itemsPerPage)
        {
            return $roles->paginate($itemsPerPage);
        }

        return $roles->paginate($defaultItemsPerPage);
    }

    public function getAllRole()
    {
        $roles = Role::with('permissions')->latest()->get();

        return $roles;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            // storing roles

            $role = new Role();

            $role->name = $request->name;

            $role->syncPermissions($request->input('permission'));

            $role->save();

            DB::commit();

            return $role;

        }catch (\Throwable $th){
            DB::rollBack();

            throw $th;
        }
    }

    public function edit($id)
    {
        $role = Role::where('id', $id)->with('permissions')->first();

        if ($id != $role->id)
        {
            throw new \Exception("Model not found");
        }

        return $role;
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            // update role

            $role = Role::findOrFail($id);

            $role->name = $request->name;

            $role->syncPermissions($request->input('permission'));

            $role->save();

            DB::commit();

            return $role;

        }catch (\Throwable $th){
            DB::rollBack();

            throw $th;
        }
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        $role->permissions()->detach();

        $role->delete();

        return $role;
    }
}
