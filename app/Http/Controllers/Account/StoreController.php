<?php namespace MrCoffer\Http\Controllers\Account;

use MrCoffer\Bank;
use Illuminate\Http\Request;
use MrCoffer\Account\Account;
use Illuminate\Auth\AuthManager;
use MrCoffer\Account\Type as AccountType;
use MrCoffer\Http\Controllers\Controller;

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
     * Authentication service.
     *
     * @var AuthManager
     */
    protected $auth;

    /**
     * Request service
     *
     * @var Request
     */
    protected $request;

    /**
     * Account Type model instance.
     *
     * @var AccountType
     */
    protected $accountType;

    /**
     * Bank Model instance.
     *
     * @var Bank
     */
    protected $bank;

    /**
     * StoreController constructor.
     *
     * @param AuthManager $auth
     * @param Request     $request
     * @param AccountType $accountType
     * @param Bank        $bank
     */
    public function __construct(AuthManager $auth, Request $request, AccountType $accountType, Bank $bank)
    {
        $this->middleware('auth');
        $this->auth = $auth;
        $this->request = $request;
        $this->bank = $bank;
    }

    /**
     * Store a new Account
     *
     * @param Account $account
     */
    public function store(Account $account)
    {
        $account->setAttribute('user_id', $this->auth->guard()->user());

        $this->validate($this->request, [
            'name' => 'required',
            'number' => 'required|unique:accounts',
            'account-type' => 'required|exists:accountTypes,id',
            'bank' => 'required|exists:banks,id',
        ]);
    }
}