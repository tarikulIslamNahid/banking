<?php

namespace App\Http\Services\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    use AuthenticatesUsers;
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

    public function login(Request $request)
    {
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $user = User::where("email", $request->email)->first();

        if ($user == null) {
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        }

        if (!Hash::check($request->password, $user->password)) {
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        }

        $this->clearLoginAttempts($request);
        $token = $user->createToken($user->id)->plainTextToken;
        return [
            'user'      => $user,
            'token'     => $token,
        ];
    }
}
