<?php

namespace MrCoffer\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use MrCoffer\User;

/**
 * Class Dashboard
 */
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        /* @var $user User */
        $user = Auth::user();

        return view('dashboard.main', ['user' => $user]);
    }
}
