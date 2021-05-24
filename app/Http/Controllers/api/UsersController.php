<?php

namespace App\Http\Controllers\api;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\EloquentVueTables;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        $query = User::query();
        $tablePaginate = new EloquentVueTables();
        return $tablePaginate->get($query, ['id', 'name', 'email', 'created_at']);
    }

    public function listarRoles()
    {
        return Role::where('name', '<>', 'Admin')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 422);
        }

        $user = new User();
        if ($validator->passes()) {
            $user->fill($validator->validated());
            $user->save();
            $user->assignRole('Admin');
            return response()->json(['messages' => "El usuario se guardó correctamente", 'success' => true], 200);
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['errors' => 'No se encuentra el usuario', 'success' => false], 422);
        } else {
            $user = User::destroy($id);
            return response()->json(['messages' => "El usuario se Eliminó correctamente", 'success' => true], 200);
        }
    }

    public function selectUser(Request $request)
    {
        $id = $request->id;
        $user = User::with('roles')->where('id', '=', $id)->first();
        $rol = $user->roles->implode('name', ', ');
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'rol' => $rol,
        ];
    }

    public function getRolUser()
    {
        $user = Auth::user();
        return $rol = $user->roles->implode('name', ', ');
    }

    public function UpdateUser(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'id' => 'exists:App\User,id'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 422);
        }

        if ($validator->passes()) {
            $name = $request->name;
            $email = $request->email;
            $password = $request->password;

            $user = User::find($request->id);
            $user->name = $name;
            $user->email = $email;
            if ($password != '') {
                $user->password = Hash::make($password);
            }
            $user->save();
            return response()->json(['messages' => "El usuario se actualizó correctamente", 'success' => true], 201);
        }
    }
}
