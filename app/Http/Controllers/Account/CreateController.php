<?php

namespace MrCoffer\Http\Controllers\Account;

use Illuminate\Contracts\View\View as ViewInterface;
use Illuminate\View\Factory as ViewFactory;
use MrCoffer\Account\Type as AccountType;
use MrCoffer\Bank;
use MrCoffer\Http\Controllers\Controller;

/**
 * Class CreateController
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
     *
     * @param Bank        $bank
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
     * @param ViewFactory $viewFactory
     *
     * @return ViewInterface
     */
    public function create(ViewFactory $viewFactory)
    {
        $data = [
            'accountTypes' => $this->accountType->all(),
            'banks'        => $this->bank->all(),
        ];

        return $viewFactory->make('account.create', $data);
    }
}
