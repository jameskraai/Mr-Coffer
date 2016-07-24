<?php

namespace MrCoffer\Policies;

use MrCoffer\Account\Account;
use MrCoffer\User;

/**
 * Class AccountPolicy
 */
class AccountPolicy
{
    /**
     * Check if the User owns the provided account.
     *
     * @param User    $user
     * @param Account $account
     *
     * @return bool
     */
    public function canShow(User $user, Account $account)
    {
        return $user->owns($account);
    }
}
