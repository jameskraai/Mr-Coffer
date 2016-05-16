<?php namespace MrCoffer\Http\Controllers\Account;

use MrCoffer\Bank;
use Illuminate\View\Factory as View;
use MrCoffer\Http\Controllers\Controller;
use MrCoffer\Account\Type as AccountType;

/**
 * Class CreateController
 * @package MrCoffer\Http\Controllers\Account
 */
class CreateController extends Controller
{
    /**
     * Bank model instance.
     *
     * @var Bank
     */
    protected $bank;

    /**
     * Account Type model instance.
     *
     * @var AccountType
     */
    protected $accountType;

    /**
     * CreateController constructor.
     * @param Bank $bank
     * @param AccountType $accountType
     */
    public function __construct(Bank $bank, AccountType $accountType)
    {
        $this->bank = $bank;
        $this->accountType = $accountType;
    }


    /**
     * Create a new Account view.
     *
     * @param View $view
     * @return \Illuminate\Contracts\View\View
     */
    public function create(View $view)
    {
        $data = [
            'accountTypes' => $this->accountType->all(),
            'banks' => $this->bank->all(),
        ];

        return $view->make('account.create', $data);
    }
}