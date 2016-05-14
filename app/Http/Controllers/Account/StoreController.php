<?php namespace MrCoffer\Http\Controllers\Account;

use Illuminate\Http\Request;
use MrCoffer\Account\Account;
use Illuminate\Auth\AuthManager;
use MrCoffer\Http\Controllers\Controller;
use Illuminate\Routing\Redirector as Redirect;

/**
 * Class StoreController
 * This class is responsible for storing a new Account and redirecting back to the dashboard
 * or back to the form with an error message.
 *
 * @package MrCoffer\Http\Controllers\Account
 */
class StoreController extends Controller
{
    /**
     * This service allows us to get and set information about the current
     * Authentication state - for example we can use it to get the
     * currently Authenticated User model.
     *
     * @var AuthManager
     */
    protected $auth;

    /**
     * This is used to validate the received POST data from a form and
     * pass it to a validator or use it to set against a Model.
     *
     * @var Request
     */
    protected $request;

    /**
     * Useful for making and sending a redirect http response
     * to a specific named route.
     *
     * @var Redirect
     */
    protected $redirect;

    /**
     * StoreController constructor.
     *
     * @param AuthManager $auth
     * @param Request     $request
     * @param Redirect    $redirect
     */
    public function __construct(AuthManager $auth, Request $request, Redirect $redirect)
    {
        $this->middleware('auth');
        $this->auth = $auth;
        $this->request = $request;
        $this->redirect = $redirect;
    }

    /**
     * Validates the received information from the Http Request then assigns all
     * required properties to a new Account model, if successful this method
     * will return a RedirectResponse back to the dashboard.
     *
     * @param Account $account
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Account $account)
    {
        // Get the currently Authenticated User Eloquent Model.
        /** @var \Illuminate\Database\Eloquent\Model $user */
        $user = $this->auth->guard()->user();

        // Set the 'user_id' of the new Account to the authenticated User ID.
        $account->setAttribute('user_id', $user->getAttribute('id'));

        // Validate the received values in the http request.
        $this->validate($this->request, [
            'name' => 'required',
            'number' => 'required|unique:accounts',
            'account-type' => 'required|exists:accountTypes,id',
            'bank' => 'required|exists:banks,id',
        ]);

        // Grab the rest of the received items in the request and set as attributes
        // on the new Account model.
        $account->setAttribute('name', $this->request->input('name'));
        $account->setAttribute('number', $this->request->input('number'));
        $account->setAttribute('type_id', $this->request->input('account-type'));
        $account->setAttribute('bank_id', $this->request->input('bank'));

        // Save the new Account model.
        $account->save();

        // Redirect back to the dashboard.
        return $this->redirect->route('dashboard');
    }
}