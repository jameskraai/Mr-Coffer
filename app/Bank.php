<?php

namespace MrCoffer;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Bank
 * Represents a Bank, a User can assign many Accounts to a Bank instance.
 */
class Bank extends Model
{
    /**
     * Mass assignable attributes.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Get the Accounts associated with this Bank.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany('MrCoffer\Account\Account');
    }
}
