<?php

namespace MrCoffer\Account;

use Illuminate\Database\Eloquent\Model;

/**
 * class Account
 * Represents a financial account owned by a User.
 */
class Account extends Model
{
    /**
     * Mass assignable attributes, the created_at attribute is fillable
     * here because it represents when the account was made at
     * the financial institution.
     *
     * @var array
     */
    protected $fillable = ['name', 'user_id', 'number', 'type_id', 'bank_id', 'created_at'];

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
     * Get the User that this Account belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('MrCoffer\User');
    }

    /**
     * Get the Bank that this Account belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bank()
    {
        return $this->belongsTo('MrCoffer\Bank');
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
