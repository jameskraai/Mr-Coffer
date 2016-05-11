<?php namespace MrCoffer\Http\Controllers\Account;

use MrCoffer\Http\Controllers\Controller;

/**
 * Class StoreController
 * @package MrCoffer\Http\Controllers\Account
 */
class StoreController extends Controller
{
    public function store()
    {
        return redirect('dashboard');
    }
}