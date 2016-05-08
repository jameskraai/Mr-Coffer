<?php namespace MrCoffer\Http\Controllers\Account;

use MrCoffer\Account\Account;
use MrCoffer\Http\Controllers\Controller;

/**
 * Class AccountShowCtrl
 * This controller is singularly responsible for displaying a single
 * Account that the current User is authorized to view.
 *
 * @package MrCoffer\Http\Controllers\Account
 */
class ShowController extends Controller
{
    /**
     * AccountShowCtrl constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return mixed
     */
    public function show($id)
    {
        $account = Account::where('id', $id)->first();

        return view('account.show', ['account' => $account]);
    }
}