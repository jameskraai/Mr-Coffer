<?php

namespace MrCoffer;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    /**
     * Mass assignable attributes.
     *
     * @var array
     */
    protected $fillable = ['name'];
}
