<?php

namespace MrCoffer\Http\Controllers;

use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * Class HomeController
 * This controller displays a logged in User's home screen.
 */
class HomeController extends Controller
{
    /**
     * Contains information as to the current authentication
     * state - specifically getting the currently
     * authenticated User.
     *
     * @var AuthManager
     */
    protected $authManager;

    /**
     * Factory that makes new Blade templates.
     *
     * @var ViewFactory
     */
    protected $viewFactory;

    /**
     * HomeController constructor.
     *
     * @param AuthManager $authManager Gets authenticated User.
     * @param ViewFactory $viewFactory Makes blade templates.
     */
    public function __construct(AuthManager $authManager, ViewFactory $viewFactory)
    {
        $this->authManager = $authManager;
        $this->viewFactory = $viewFactory;
    }

    /**
     * Displays the home view.
     *
     * @return View
     */
    public function index()
    {
        /**
         * Get the currently authenticated User.
         *
         * @var Model $user
         */
        $user = $this->authManager->guard()->user();

        // Data to be passed to our blade template.
        $templateData = ['user' => $user];

        // Make our home view.
        $homeView = $this->viewFactory->make('home.main', $templateData);

        return $homeView;
    }
}
