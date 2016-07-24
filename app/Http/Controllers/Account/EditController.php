<?php

namespace MrCoffer\Http\Controllers\Account;

use Illuminate\Contracts\View\View as ViewInterface;
use Illuminate\View\Factory as View;
use MrCoffer\Account\Account;
use MrCoffer\Account\Type as AccountType;
use MrCoffer\Bank;
use MrCoffer\Http\Controllers\Controller;

class EditController extends Controller
{
    /**
     * Bank model instance.
     *
     * @var Bank
     */
    protected $bank;

    /**
     * Account model instance.
     *
     * @var Account
     */
    protected $account;

    /**
     * Account Type model instance.
     *
     * @var AccountType
     */
    protected $accountType;

    /**
     * View template service.
     *
     * @var View
     */
    protected $view;

    public function __construct(Bank $bank, Account $account, AccountType $accountType, View $view)
    {
        $this->bank = $bank;
        $this->account = $account;
        $this->accountType = $accountType;
        $this->view = $view;
    }

    /**
     * Edit an Account.
     *
     * @param $id
     *
     * @return ViewInterface
     */
    public function edit($id)
    {
        $account = $this->account->query()->where('id', $id)->firstOrFail();

        $data = [
            'account'       => $account,
            'accountTypes'  => $this->accountType->all(),
            'banks'         => $this->bank->all(),
        ];

        return $this->view->make('account.edit', $data);
    }
}
