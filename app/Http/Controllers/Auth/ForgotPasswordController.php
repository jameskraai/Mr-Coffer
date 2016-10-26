<?php

namespace MrCoffer\Http\Controllers\Auth;

use MrCoffer\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

/**
 * Class ForgotPasswordController
 * This controller is responsible for handling password reset emails and
 * includes a trait which assists in sending these notifications from
 * this application.
 */
class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * ForgotPasswordController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}