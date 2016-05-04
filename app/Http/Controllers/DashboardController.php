<?php

namespace MrCoffer\Http\Controllers;

use MrCoffer\User;
use MrCoffer\Http\Requests;
use Illuminate\Support\Facades\Auth;

/**
 * Class Dashboard
 * @package MrCoffer\Http\Controllers
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
