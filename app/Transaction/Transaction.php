<?php

namespace MrCoffer;

use Illuminate\Database\Eloquent\Model;

/**
 * class Transaction
 *
 * @package MrCoffer\Transaction
 */
class Transaction extends Model
{
    /**
     * Mass assignable properties
     *
     * @var array
     */
    protected $fillable = [
        'account_id',
        'memo',
        'category_id',
        'amount',
        'payee_id',
        'status_id'
    ];
}
