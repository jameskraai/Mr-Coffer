<?php

namespace MrCoffer\Http\Controllers;

use MrCoffer\User;
use Illuminate\Auth\AuthManager;

/**
 * Class WelcomeController
 * Default route which indicates whether the User is authenticated or not.
 */
class WelcomeController extends Controller
{
    /**
     * Auth Manager, this is used to retrieve the
     * User authorized with the current Token.
     *
     * @var AuthManager
     */
    protected $authManager;

    /**
     * WelcomeController constructor.
     * @param AuthManager $authManager
     */
    public function __construct(AuthManager $authManager)
    {
        $this->middleware(['wantJson', 'auth:api']);
        $this->authManager = $authManager;
    }

    /**
     * Return a string.
     *
     * @return string
     */
    public function index()
    {
        /**
         * The User that is currently authenticated
         * via the bearer token.
         *
         * @var User $user
         */
        $user = $this->authManager->guard('api')->user();

        $message = "You have arrived {$user->getAttribute('name')}.";

        return json_encode([$message]);
    }
}
