<?php

namespace MrCoffer\Http\Controllers\Auth;

use MrCoffer\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

/**
 * Class ResetPasswordController
 * This controller is responsible for handling password reset requests
 * and uses a simple trait to include this behavior.
 */
class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}
