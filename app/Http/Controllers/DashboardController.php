<?php

namespace MrCoffer\Http\Controllers;

use Illuminate\Http\Request;

use MrCoffer\Http\Requests;

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
        return view('welcome');
    }
}
