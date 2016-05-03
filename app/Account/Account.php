<?php namespace MrCoffer\Account;

use Illuminate\Database\Eloquent\Model;

/**
 * class Account
 * Represents a financial account owned by a User.
 *
 * @package MrCoffer
 */
class Account extends Model
{
    /**
    * Mass assignable attributes.
    *
    * @var array
    */
    protected $fillable = ['user_id', 'number', 'type_id', 'created_at'];

    /**
     * Get the Type associated with this Account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function type()
    {
        return $this->hasOne('MrCoffer\Account\Type');
    }

    /**
     * Get the Transactions associated with this Account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany('MrCoffer\Transaction\Transaction');
    }
}
