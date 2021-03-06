<?php

namespace MrCoffer\Transaction;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Payee
 * Represents a Payee associated with a Transaction.
 */
class Payee extends Model
{
    /**
     * Mass assignable attributes.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Get the Transaction this Payee belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction()
    {
        return $this->hasMany('MrCoffer\Transaction\Transaction');
    }
}
