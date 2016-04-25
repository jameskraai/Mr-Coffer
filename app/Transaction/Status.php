<?php

namespace MrCoffer\Transaction;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Status
 * Represents the Status of a Transaction.
 *
 * @package MrCoffer\Transaction
 */
class Status extends Model
{
    /**
     * Table name in the DB.
     *
     * @var string
     */
    protected $table = 'statuses';

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['name'];
}
