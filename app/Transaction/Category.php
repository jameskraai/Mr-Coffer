<?php

namespace MrCoffer\Transaction;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * The 'category' that a Transaction may have.
 */
class Category extends Model
{
    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * Mass assignable attributes.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Get the Transaction that this belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction()
    {
        return $this->hasMany('MrCoffer\Transaction\Transaction');
    }
}
