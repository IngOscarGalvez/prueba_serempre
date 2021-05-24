<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Log;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;


class AcountContoller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function AcountUser()
    {
        $user = Auth::user();

        $rol = $user->roles->implode('name', ', ');

        return [
            'user' => $user,
            'rol' => $rol
        ];
    }


    public function UpdateUser(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = Auth::user();

        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        $user = User::find($user['id']);
        $user->name = $name;
        $user->email = $email;

        $user_data = User::where('id', '=', $user['id'])->first();


        if ($password != '') {
            $user->password = Hash::make($password);
        }

        $user->save();
    }
}
