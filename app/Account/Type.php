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
    /**
     * Mass assignable attributes.
     *
     * @var array
     */
    protected $fillable = ['name'];
}
