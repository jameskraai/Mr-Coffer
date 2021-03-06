<?php

use Illuminate\Database\Seeder;
use MrCoffer\Account\Account;
use MrCoffer\Account\Type as AccountType;
use MrCoffer\Bank;
use MrCoffer\User;

class AccountsTableSeeder extends Seeder
{
    /**
     * Eloquent Model Instance.
     *
     * @var Account
     */
    protected $account;

    /**
     * Type of Account Eloquent Model Instance.
     *
     * @var AccountType
     */
    protected $accountType;

    /**
     * User model.
     *
     * @var User
     */
    protected $user;

    /**
     * AccountsTableSeeder constructor.
     *
     * @param Account     $account
     * @param AccountType $accountType
     * @param User        $user
     */
    public function __construct(Account $account, AccountType $accountType, User $user)
    {
        $this->account = $account;
        $this->accountType = $accountType;
        $this->user = $user;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = $this->user->newQuery()->where('email', 'mrcoffer@example.com')->firstOrFail();
        $accountType = $this->accountType->newQuery()->where('name', 'checking')->firstOrFail();

        $chase = Bank::where('name', 'chase')->first();

        $this->account->user_id = $user->id;
        $this->account->number = 11292014;
        $this->account->type_id = $accountType->id;
        $this->account->bank_id = $chase->id;
        $this->account->name = 'My Checking';
        $this->account->save();
    }
}
