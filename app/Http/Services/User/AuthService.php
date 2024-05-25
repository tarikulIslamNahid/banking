<?php

namespace App\Http\Services\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthService
{
    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->account_type = $request->account_type;
        $user->save();
        DB::commit();
        return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }
}
