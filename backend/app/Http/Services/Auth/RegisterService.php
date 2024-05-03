<?php

namespace App\Http\Services\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterService
{
    public function register(Request $request)
    {
        DB::beginTransaction();

        try {

            //register user

            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);

            $role = "employee";

            $user->assignRole($role);

            $user->save();

            DB::commit();

            return $user;
        }catch (\Throwable $throwable){

            DB::rollBack();

            throw $throwable;
        }
    }
}
