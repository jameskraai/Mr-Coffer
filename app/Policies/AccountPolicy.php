<?php

namespace MrCoffer\Policies;

use MrCoffer\User;
use MrCoffer\Account\Account;

/**
 * Class AccountPolicy
 *
 * @package MrCoffer\Policies
 */
class AccountPolicy
{
    /**
     * Check if the User owns the provided account.
     *
     * @param User $user
     * @param Account $account
     * @return bool
     */
    public function canShow(User $user, Account $account)
    {
        return $user->owns($account);
    }
}
