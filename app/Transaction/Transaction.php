<?php

namespace MrCoffer\Transaction;

use Illuminate\Database\Eloquent\Model;

/**
 * class Transaction
 */
class Transaction extends Model
{
    /**
     * Mass assignable properties.
     *
     * @var array
     */
    protected $fillable = [
        'account_id',
        'memo',
        'category_id',
        'amount',
        'payee_id',
        'status_id',
    ];

    /**
     * Get the Account that this Transaction belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo('MrCoffer\Account\Account');
    }

    /**
     * Get the Category for this Transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->belongsTo('MrCoffer\Transaction\Category');
    }

    /**
     * Get the Payee for this Transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payee()
    {
        return $this->belongsTo('MrCoffer\Transaction\Payee');
    }

    /**
     * Get the Status of this Transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function status()
    {
        return $this->belongsTo('MrCoffer\Transaction\Status');
    }
}
