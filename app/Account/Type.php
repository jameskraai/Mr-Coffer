<?php namespace MrCoffer\Account;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Type
 * The 'Type' of Account.
 *
 * @package MrCoffer\Account
 */
class Type extends Model
{
    protected $table = 'accountTypes';

    /**
     * Mass assignable attributes.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Get the Account that this Type belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo('MrCoffer\Account\Account');
    }
}
