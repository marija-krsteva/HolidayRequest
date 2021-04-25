<?php

namespace App\Http\Controllers;

use App\Models\User;
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $current_user = User::find(Auth::id());
        $role_key = array_keys(User::getRoles(), $current_user->role);
        $current_user_role_key = $role_key[0];
        $users = $current_user->filterUsers();

        return view('home',
            ['users' => $users,
            'current_user_role' => $current_user_role_key]
        );
    }
}
