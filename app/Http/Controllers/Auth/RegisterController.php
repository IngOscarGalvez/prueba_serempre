<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Registered;
use App\Jobs\SendEmail;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function sendEmail()
    {

        $data = request()->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if ($user) {
            $message = [
                'message' => "El usuario con email {$data['email']} existe"
            ];
            return response()->json($message, 200);
        }

        $userRegisted = Registered::where('email', $data['email'])->first();
        if ($userRegisted) {
            $userRegisted = [
                'message' => "El usuario con email {$data['email']} ya fue registrado, por favor verifique su correo electronico para continuar con la validación"
            ];
            return response()->json($userRegisted, 200);
        }

        // save
        $newUserPassword = Str::random(10);
        Registered::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($newUserPassword),
        ]);

        SendEmail::dispatch('Por favor Valida tu usuario', $data['email'], $newUserPassword);

        return response()->json(['redirect' => true]);
    }

    public function register()
    {
        return view('register');
    }

    public function createUser()
    {
        // dd(request()->all());
        $data = request()->validate([
            'email' => ['required', 'email'],
            'pass' => ['required'],
            'token' => ['required'],
        ]);

        try {
            $user = Registered::where('email', $data['email'])->first();

            if (!$user) {
                return response()
                    ->json([
                        'message' => 'El usuario no existe, por favor registrate primero!'
                    ], 404);
            }

            if (!Hash::check($data['token'], $user->password)) {
                return response()->json([
                    'message' => 'La contraseña es incorrecta!'
                ]);
            }

            // create user
            User::create([
                'name' => $user['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['pass'])
            ]);

            return response()->json(['redirect' => true]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
