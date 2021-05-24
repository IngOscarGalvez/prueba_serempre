<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index()
    {
        $user = Auth::user();

        $rol=$user->roles->implode('name',', ');



        switch ($rol) {
            case 'Admin':
                return redirect('/admin/users'); // esto cambia para el dashboard
                break;
            case 'User':
                return redirect('404'); // se cambia cuando hay usuario
                break;
            default:
                return redirect('404');
                break;


        }
    }
}
