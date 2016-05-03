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
}
