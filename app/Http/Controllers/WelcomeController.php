<?php

namespace MrCoffer\Http\Controllers;

/**
 * Class Dashboard
 */
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('wantJson');
    }

    /**
     * Return a string.
     *
     * @return string
     */
    public function index()
    {
        $json = json_encode(['You have arrived.']);

        return $json;
    }
}
